<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    use HasFactory;

    public static function getFileTypes() {
        $types = FileType::get();
        // $types_array = [];
        // foreach($types as $t) {
        //     $types_array[$t->id] = $t->name;
        // }

        return $types;
    }
}
