<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTypePerCareer extends Model
{
    use HasFactory;

    public static function getStudentTypePerCareers($careerId)
    {
        $types = StudentTypePerCareer::where('career_id', "=", $careerId)->get();
        return $types;
    }
    public static function getAllStudentTypes()
    {
        $types = StudentTypePerCareer::get();
        return $types;
    }
    public static function getStudentTypePerCareersArray($careerId)
    {
        $types = StudentTypePerCareer::where('career_id', "=", $careerId)->get();
        $types_array = [];
        foreach ($types as $s) {
            $types_array[$s->id] = $s->name;
        }
        return $types_array;
    }
    public function careers()
    {
        return $this->belongsTo('App\Models\Career', 'career_id');
    }
}
