<?php

namespace App\Http\Controllers;

use App\Models\StudentTypePerCareer;
use Illuminate\Http\Request;

class StudentTypePerCareersController extends Controller
{
    public function adminViewStudents()
    {
        $students = StudentTypePerCareer::query()->with('careers')->paginate(20);
        $careers = \App\Models\Career::getCareers();
        return view('admin.student-view', ['students' => $students, 'careers' => $careers]);
    }
    public function adminUpdateStudent(Request $req)
    {
        try {
            $validate = $req->validate([
                'name' => 'required',
            ]);
            $career = StudentTypePerCareer::find($req->id);
            $career->name = $validate['name'];
            $career->save();
            return redirect()->route('admin-students', ['success' => true, 'desc' => 'Student updated successfully']);
        } catch (\Throwable $th) {
            return redirect()->route('admin-students', ['success' => false, 'desc' => $th]);
        }
    }
    public function adminAddStudent(Request $req)
    {
        try {
            $validate = $req->validate([
                'name' => 'required',
                'career' => 'required'
            ]);
            $career = new StudentTypePerCareer();
            $career->name = $validate['name'];
            $career->career_id = $validate['career'];
            $career->save();
            return redirect()->route('admin-students', ['success' => true, 'desc' => 'Student added successfully']);
        } catch (\Throwable $th) {
            return redirect()->route('admin-students', ['success' => false, 'desc' => $th]);
        }
    }
    public function adminRemoveStudent(Request $req)
    {
        try {
            $career = StudentTypePerCareer::find($req->id);
            $career->delete();
            return redirect()->route('admin-students', ['success' => true, 'desc' => 'Student removed successfully']);
        } catch (\Throwable $th) {
            return redirect()->route('admin-students', ['success' => false, 'desc' => $th]);
        }
    }
}
