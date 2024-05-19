<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function type() {
        return $this->belongsTo('App\Models\FileType','file_type_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
