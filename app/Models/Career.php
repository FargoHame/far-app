<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    public static function getCareers()
    {
        $careers = Career::get();
        $careers_array = [];
        foreach ($careers as $s) {
            $careers_array[$s->id] = $s->name;
        }
        return $careers_array;
    }
}
