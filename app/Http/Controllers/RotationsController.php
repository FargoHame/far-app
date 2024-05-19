<?php

namespace App\Http\Controllers;

use App\Traits\FileTrait;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Rotation;
use App\Models\RotationImage;
use App\Models\Specialty;
use App\Models\FileType;
use App\Models\RotationAvailability;
use App\Models\StudentTypePerCareer;
use Carbon\Carbon;

class RotationsController extends Controller
{
    use FileTrait;

    public function rotations(Request $request) {
        $user = Auth::user();
        if (isset($request->status)) {
            $status = 'archived';
            $rotations = Rotation::where(['preceptor_user_id' => $user->id])->where('status', '=', $status)->paginate(config("rotation.pagination_size"))->withQueryString();
        } else {
            $status = '';
            $rotations = Rotation::where(['preceptor_user_id' => $user->id])->where('status', '!=', 'archived')->paginate(config("rotation.pagination_size"))->withQueryString();
        }
        return view('preceptor.rotations', ['rotations' => $rotations, 'status' => $status]);
    }

    public function edit(Rotation $rotation = null) {
        if ($rotation == null) {
            $rotation = new Rotation();
            $rotation->preceptor_name = Auth::user()->name();
        }

        return view('preceptor.rotation-edit',['rotation' => $rotation,'specialties' => Specialty::getSpecialties(),'file_types' => FileType::getFileTypes()]);
    }

    public function update(Request $request) {
        $validations = [
            'preceptor_name' => 'required|string|max:255',
            'hospital_name' => 'required|string|max:255',
            'zipcode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'price_per_week' => 'required|numeric',
            'type' => 'required|in:inpatient,outpatient,observerships,pre_med_shadowing,virtual_observerships,virtual_shadowing,research,virtual_research',
            'description' => 'nullable|string',
            'specialties.*' => 'distinct',
            'studentType' => 'required'
        ];
        $validatedData = $request->validate(
            $validations,
            [
                'specialties.*.distinct' => "You've selected the same specialty more than once"
            ]
        );

        $rotation = $request->input("id") ? Rotation::findOrFail($request->id) : new Rotation();

        $rotation->fill($validatedData);
        $rotation->preceptor_user_id = Auth::user()->id;
        $rotation->price_per_week_in_cents = $validatedData['price_per_week'] * 100;
        $is_active = containEmailPhoneWebsite($request->description);
        $rotation->active = $is_active == true ? 0 : 1 ;
        $rotation->save();

        $rotation->specialties()->detach();

        foreach($request->specialties as $specialtyID) {
            $s = Specialty::find($specialtyID);
            $rotation->specialties()->attach($s);
        }
        $rotation->student_types()->detach();

        $s = StudentTypePerCareer::find($validatedData['studentType']);
        $rotation->student_types()->attach($s);

        $rotation->file_types()->detach();

        foreach(($request->file_types ?? []) as $fileTypeID) {
            $ft = FileType::find($fileTypeID);
            $rotation->file_types()->attach($ft);
        }

        foreach(($request->file('images') ?? []) as $file) {
            $this->upFileRotation($file,$rotation);
        }

        foreach(($request->removed_images ?? []) as $file) {
            RotationImage::find($file)->delete();
        }

        if ($request->input("id")==null) {
            return redirect()->route('preceptor-rotation-calendar',['rotation' => $rotation]);
        }

        return redirect()->route('preceptor-rotations');
    }

    public function calendar(Rotation $rotation )
    {
        $weeks = [];
        for ($i = 0; $i < 30; $i++) {
            $start = Carbon::now()->addDays(7 * $i)->startOfWeek();
            $availability = RotationAvailability::where(['rotation_id' => $rotation->id, 'starts_at' => $start])->first();
            $weeks[] = [
                'start' => $start,
                'enabled' => ($availability != null && $availability->status == "enabled") ? true : false,
                'seats' => ($availability != null && $availability->status == "enabled") ? $availability->seats : 1,
                'confirmed' => ($availability != null) ? $availability->applications()->where(['status' => 'paid'])->count() : 0
            ];
        }

        return view('preceptor.rotation-calendar', ['rotation' => $rotation,'weeks' => $weeks]);
    }

    public function updateCalendar(Request $request) {
        $rotation = Rotation::findOrFail($request->id);

        $flagCount=false;
        for($i=0;$i<30;$i++) {
            if ($request->input("week_".$i."_enabled")) {
                $week = $request->input("week_".$i);
                $slots = $request->input("week_".$i."_slots") ?? 0;
                $flagCount=true;

                // check for current availability record
                $availability = RotationAvailability::where(['rotation_id' => $rotation->id, 'starts_at' => $week])->first() ?? new RotationAvailability();
                $availability->rotation_id = $rotation->id;
                $availability->starts_at = $week;
                $availability->seats = $slots;
                $availability->status = 'enabled';
                $availability->save();
            }

        }


        // disable unselected weeks
        for($i=0;$i<30;$i++) {
            $start = Carbon::now()->addDays(7 * $i)->startOfWeek();
            $availability = RotationAvailability::where(['rotation_id' => $rotation->id, 'starts_at' => $start])->first();
            if ($availability && $request->input("week_".$i."_enabled") == null) {
                $availability->status = 'disabled';
                $availability->save();
            }
        }

        // if you do not select a week, the number 1 is inserted by default
        if (!$flagCount){

            $week = $request->input("week_1");
            $slots = $request->input("week_1_slots") ?? 0;

            // check for current availability record
            $availability = RotationAvailability::where(['rotation_id' => $rotation->id, 'starts_at' => $week])->first() ?? new RotationAvailability();
            $availability->rotation_id = $rotation->id;
            $availability->starts_at = $week;
            $availability->seats = $slots;
            $availability->status = 'enabled';
            $availability->save();
        }

        return redirect()->route('preceptor-rotations');
    }

    public function view(Rotation $rotation) {
        if (Auth::user()->role=='admin') {
            return view('admin.rotation-view',['rotation' => $rotation]);
        }
        return view('preceptor.rotation-view',['rotation' => $rotation]);
    }

    public function changeStatus(Rotation $rotation, $status) {
        if (!in_array($status,['published','disabled','archived'])) {
            exit(500);
        }
        $rotation->status = $status;
        $rotation->save();

        return redirect()->route('preceptor-rotations');
    }
    public function addRotationDocument(Request $req)
    {
        try {
            $file = new FileType();
            $file->name = $req->name;
            $file->user_id = $req->user;
            $file->save();
            return response()->json(['file' => $file,], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th,], 400);
        }
    }
}
function containEmailPhoneWebsite($text) {
    $email = preg_match('/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/', $text); //emails
    $website = preg_match('/\b(?:https?|ftp):\/\/\S+\b/', $text); //link
    $website2 = preg_match('/\b(?:www\.)?[a-zA-Z0-9]+\.[a-zA-Z]{2,}\b/', $text); //link without https or http
    $phone = preg_match('/\b\d{3}[-.]?\d{3}[-.]?\d{4}\b/', $text); //phone with format
    $phone2 = preg_match('/\b\d{10}\b/', $text); //phone without format
    return $email || $website || $website2 || $phone || $phone2;
}
