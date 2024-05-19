<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    public static function getSpecialties($any = false) {
        $specialties = Specialty::get();
        $specialties_array = [];
        foreach($specialties as $s) {
            $specialties_array[$s->id] = $s->name;
        }

        if ($any) {
            $specialties_array = [0 => 'Any'] + $specialties_array ;
        }

        return $specialties_array;
    }
}
