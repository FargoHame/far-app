<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    public function adminViewCareer()
    {
        $careers = Career::paginate(20);
        return view('admin.careers-view', compact('careers'));
    }
    public function adminUpdateCareer(Request $req)
    {
        try {
            $validate = $req->validate([
                'name' => 'required',
            ]);
            $career = Career::find($req->id);
            $career->name = $validate['name'];
            $career->save();
            return redirect()->route('admin-careers', ['success' => true, 'desc' => 'Career updated successfully']);
        } catch (\Throwable $th) {
            return redirect()->route('admin.careers', ['success' => false, 'desc' => $th]);
        }
    }
    public function adminAddCareer(Request $req)
    {
        try {
            $validate = $req->validate([
                'name' => 'required',
            ]);
            $career = new Career();
            $career->name = $validate['name'];
            $career->save();
            return redirect()->route('admin-careers', ['success' => true, 'desc' => 'Career added successfully']);
        } catch (\Throwable $th) {
            return redirect()->route('admin-careers', ['success' => false, 'desc' => $th]);
        }
    }
    public function adminRemoveCareer(Request $req)
    {
        try {
            $career = Career::find($req->id);
            $career->delete();
            return redirect()->route('admin-careers', ['success' => true, 'desc' => 'Career removed successfully']);
        } catch (\Throwable $th) {
            return redirect()->route('admin-careers', ['success' => false, 'desc' => $th]);
        }
    }
}
