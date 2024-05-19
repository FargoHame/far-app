<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotationAvailability extends Model
{
    use HasFactory;

    protected $casts = [
        'starts_at' => 'date'
    ];

    public function applications() {
        return $this->belongsToMany('App\Models\Application','application_rotation_availabilities');
    }

    public function availableSeats() {
        return max(0,$this->seats-$this->applications()->where(['status' => 'paid'])->count());
    }

}
