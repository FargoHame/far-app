<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Rotation;

use Illuminate\Support\Facades\Storage;

class AutocompleteController extends Controller
{
    public function students(Request $request) {
        $query = $request->query('query');

        $students = User::where(['role' => 'student'])->where(function ($q) use ($query) {
            $q
                ->where('first_name','like','%'.$query.'%')
                ->orWhere('last_name','like','%'.$query.'%');
        })->get();

        $students_array = [];
        foreach($students as $student) {
            $students_array[] = ['text' => $student->name(),'id' => $student->id];
        }

        return $students_array;
    }

    public function preceptors(Request $request) {
        $query = $request->query('query');

        $preceptors = User::where(['role' => 'preceptor'])->where(function ($q) use ($query) {
            $q
                ->where('first_name','like','%'.$query.'%')
                ->orWhere('last_name','like','%'.$query.'%');
        })->get();

        $preceptors_array = [];
        foreach($preceptors as $preceptor) {
            $preceptors_array[] = ['text' => $preceptor->name(),'id' => $preceptor->id];
        }

        return $preceptors_array;
    }

    public function rotations(Request $request) {
        $query = $request->query('query');

        $rotations = Rotation::query(function ($q) use ($query) {
            $q
                ->where('preceptor_name','like','%'.$query.'%')
                ->orWhere('hospital_name','like','%'.$query.'%');
        })->get();

        $rotations_array = [];
        foreach($rotations as $rotation) {
            $rotations_array[] = ['text' => $rotation->preceptor_name . " (" . $rotation->hospital_name . ")", 'id' => $rotation->id];
        }

        return $rotations_array;
    }

    public function cities(Request $request) {
        $query = $request->query('query');

        $cities = json_decode(file_get_contents(resource_path() . '/json/zip.json'), true);
        $cities_array = [];
        foreach ($cities as $city) {
            if (stristr($city['city'], $query)) {
                $cities_array[] = $city['city'];
            } elseif (stristr($city['zip_code'], $query)) {
                $cities_array[] = $city['city'];
            }
        }

        asort($cities_array);

        return array_slice(array_values(array_unique($cities_array)), 0, 10);
    }

    public function citiestate(Request $request) {
        $query = $request->query('query');

        $USCities = json_decode(file_get_contents(resource_path() . '/json/USCities.json'),true);
        $state='';
        $city='';
        foreach($USCities as $citys) {
            if ($citys['zip_code']==intval($query)) {
                $state=$citys['state'];
                $city=$citys['city'];
            }
        }
        if ($state=='' && $city =='')
            return response()->json([]);
        return response()->json(['state'=>$state,'city'=>$city]);
    }


    public function schools(Request $request) {
        $query = $request->query('query');

        $schools = json_decode(file_get_contents(resource_path().'/json/schools.json'),true);
        $schools_array = [];
        foreach($schools as $school) {
            if (stristr($school,$query)) {
                $schools_array[] = $school;
            }
        }

        asort($schools_array);

        return array_slice(array_values(array_unique($schools_array)),0,10);
    }
}
