<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public function rotation() {
        return $this->belongsTo('App\Models\Rotation');
    }

    public function rotation_slots() {
        return $this->belongsToMany('App\Models\RotationAvailability','application_rotation_availabilities');
    }


    public function files() {
        return $this->belongsToMany('App\Models\File','application_files');
    }

    public function messages() {
        return $this->hasMany('App\Models\Message');
    }

    public function student() {
        return $this->belongsTo('App\Models\User','student_user_id');
    }
}
