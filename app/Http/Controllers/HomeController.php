<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use App\Models\Rotation;
use App\Models\Application;
use App\Models\Message;
use App\Models\RotationAvailability;
use App\Mail\NewApplicationMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use FileTrait;

    public function home()
    {
        $referral_code = $_REQUEST['r'] ?? null;
        if (!is_null($referral_code)) {
            return redirect()->route('register', ['r' => $referral_code]);
        }

        if (Auth::user() && (Auth::user()->role != 'student')) {
            return redirect()->route('dashboard');
        }
        $q = Rotation::query();
        $q->whereHas('availabilty', function ($query) {
            $query->where('starts_at', '>', \Carbon\Carbon::now())->where(['status' => 'enabled']);
        });
        $q->where(['status' => 'published']);
        $q->where(['active' => 1]);
        $rotations_initial = $q->paginate(config("rotation.pagination_size"))->withQueryString();

        return view('home', ['rotations' => $rotations_initial]);
    }

    public function search(Request $request)
    {
        $q = Rotation::query()->with('student_types');
        $q->where(['status' => 'published']);
        $q->where(['active' => 1]);

        if ($request->location != "") {
            $q->where(function ($q) use ($request) {
                $q->Where(['city' => $request->location])
                ->orWhere(['zipcode' => $request->location]);
            });
        }

        if ($request->state) {
            if ($request->state != []) {
                foreach ($request->state as $state) {
                    if ($state != null) {
                        $q->Where(['state' => $state]);
                    }
                }
            }
        }

        if ($request->type) {
            if ($request->type != []) {
                foreach ($request->type as $type) {
                    if ($type != 'any' and  $type != null) {
                        $q->where(['type' => $type]);
                    }
                }
            }
        }

        if ($request->specialty) {
            if ($request->specialty != []) {
                foreach ($request->specialty as $specialty) {
                    $q->whereHas('specialties', function ($q) use ($specialty) {
                        $q->where('specialty_id', $specialty);
                    });
                }
            }
        }

        if ($request->start_after != "") {
            $q->whereHas('availabilty', function ($query) use ($request) {
                $query->where('starts_at', '>', $request->start_after)->where(['status' => 'enabled']);
            });
        } else {
            $q->whereHas('availabilty', function ($query) use ($request) {
                $query->where('starts_at', '>', \Carbon\Carbon::now())->where(['status' => 'enabled']);
            });
        }

        if ($request->end_before != "") {
            $q->whereHas('availabilty', function ($query) use ($request) {
                $query->where('starts_at', '<', $request->end_before)->where(['status' => 'enabled']);
            });
        }
        if ($request->career != "") {
            $studentType = $request->studentType;
            $q->whereHas('student_types', function ($query) use ($studentType) {
                $query->where('student_type_per_career_id', $studentType);
            })->get();
        }

        $priceMin = 0;
        $priceMax = config('rotation.max_rotation_price');
        if ($request->price_range != "") {
            $nums = explode(";", $request->price_range);
            $priceMin = $nums[0];
            $priceMax = $nums[1];

            $q->where('price_per_week_in_cents', '>=', $priceMin * 100);
            $q->where('price_per_week_in_cents', '<=', $priceMax * 100);
        }

        $rotations = $q->paginate(config("rotation.pagination_size"))->withQueryString();

        if (isset($request->isJson)) {
            foreach ($rotations as $value) {
                $value->image = \App\Models\User::where(['id' => $value->preceptor_user_id])->firstOrFail()->photo();
                $value->price = number_format($value->price_per_week_in_cents / 100, 0);
                $specialities = [];
                foreach ($value->specialties->all() as $key2 => $item) {
                    $specialities[$key2] = $item->name;
                }
                $value->specialties = $specialities;
            }
            return response()->json(['rotations' => $rotations,'price_min' => $priceMin, 'price_max' => $priceMax]);
        } else {
            return view('search', ['rotations' => $rotations,'price_min' => $priceMin, 'price_max' => $priceMax]);
        }
    }

    public function viewRotation(Rotation $rotation, $finished = false)
    {
        if (Auth::check()) {
            $files = File::where('user_id', '=', Auth::user()->id)->where('is_manageable', '=', 1)->with('type');
            $files = $files->get();
        } else {
            $files = null;
        }
        if ($rotation->active) {
            return view('view-rotation', ['rotation' => $rotation,'finished' => $finished, 'files' => $files]);
        }
        return redirect('/');
    }

    public function applyForRotation(Request $request) {
        //check if user upload files required
        // ### get files required for the application ###
        $rotation = Rotation::find($request->rotation_id);
        $filesRequired = false;
        $documentName = '';
        foreach ($rotation->file_types as $fileType) {
            if ($request["file_saved" . $fileType->id] == null && $request->file('file_' . $fileType->id) == null) {
                $filesRequired = true;
                $documentName = $fileType->name;
            }
        }
        // return error if user didnt upload the files
        if ($filesRequired) {
            return redirect()->route('view-rotation', ['rotation' => $rotation])->with('updateDocumentsError', 'Document ' . $documentName . ' is required. Please try again.');
        }
        $user = Auth::user()->id;
        $request->validate([
            'availabilities' => 'required',
        ]);
        DB::beginTransaction();
        try {
            // save application
            $application = new Application();
            $application->student_user_id = $user;
            $application->rotation_id = $request->rotation_id;
            $application->save();
            // save message
            if ($request->message != "") {
                $m = new Message();
                $m->application_id = $application->id;
                $m->user_id = $user;
                $m->message = $request->message;
                $m->save();
            }

            foreach ($request->availabilities as $availability) {
                $a = RotationAvailability::find($availability);
                $application->rotation_slots()->attach($a);
            }
            foreach ($rotation->file_types as $fileType) {
                $name = 'file_saved' . $fileType->id;
                // check if user is trying to upload a new file even if user already have a file for this document
                if ($request->file('file_' . $fileType->id) == null) {
                    $fileup = File::where(['id' => $request->$name, 'is_manageable' => 1, 'user_id' => $user])->first();
                } else {
                    $fileup = null;
                }
                if ($fileup != null) {
                    // get file from database
                    $application->files()->attach($fileup);
                } else {
                    // upload new file
                    $file = $this->upFile($request->file('file_' . $fileType->id), $fileType->id, false);
                    $application->files()->attach($file);
                }
            }
            // save record
            DB::commit();
            // send email
            Mail::to([$application->rotation->preceptor->email])->send(new NewApplicationMail($application));
            return redirect()->route('view-rotation', ['rotation' => $rotation,'finished' => true]);
        } catch (\exception $e) {
            DB::rollback();
            return redirect()->route('view-rotation', ['rotation' => $rotation])->with('updateDocumentsError', $e->getMessage());
        }
    }
}
