<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rotation extends Model
{
    use HasFactory;

    public const TYPES = [
      'any' => 'Any',
      'inpatient' => 'Inpatient',
      'outpatient' => 'Outpatient',
      'observerships' => 'Observerships',
      'pre_med_shadowing' => 'Pre-med Shadowing',
      'virtual_observerships' => 'Virtual Observerships',
      'virtual_shadowing' => 'Virtual Shadowing',
      'research' => 'Research',
      'virtual_research' => 'Virtual Research'
    ];

    protected $fillable = [
        'preceptor_name','hospital_name','zipcode','city','state','type','description'
      ];

    public function specialties() {
      return $this->belongsToMany('App\Models\Specialty','rotation_specialties');
    }

    public function specialtyNames() {
      return  implode(", ",$this->specialties()->pluck('name')->toArray());
    }

    public function availabilty() {
      return $this->hasMany('App\Models\RotationAvailability');
    }

    public function file_types() {
      return $this->belongsToMany('App\Models\FileType','rotation_file_types');
    }
    public function student_types() {
      return $this->belongsToMany('App\Models\StudentTypePerCareer','rotation_student_type_per_careers')->withTimestamps();
    }

    public function applications() {
      return $this->hasMany('App\Models\Application');
    }

    public function images() {
      return $this->hasMany('App\Models\RotationImage');
    }

    public function preceptor() {
      return $this->belongsTo('App\Models\User','preceptor_user_id');
    }

    public static function getStates($any = true) {
      $states = [
        'AL'=>"Alabama",
        'AK'=>"Alaska",
        'AZ'=>"Arizona",
        'AR'=>"Arkansas",
        'CA'=>"California",
        'CO'=>"Colorado",
        'CT'=>"Connecticut",
        'DE'=>"Delaware",
        'DC'=>"District Of Columbia",
        'FL'=>"Florida",
        'GA'=>"Georgia",
        'HI'=>"Hawaii",
        'ID'=>"Idaho",
        'IL'=>"Illinois",
        'IN'=>"Indiana",
        'IA'=>"Iowa",
        'KS'=>"Kansas",
        'KY'=>"Kentucky",
        'LA'=>"Louisiana",
        'ME'=>"Maine",
        'MD'=>"Maryland",
        'MA'=>"Massachusetts",
        'MI'=>"Michigan",
        'MN'=>"Minnesota",
        'MS'=>"Mississippi",
        'MO'=>"Missouri",
        'MT'=>"Montana",
        'NE'=>"Nebraska",
        'NV'=>"Nevada",
        'NH'=>"New Hampshire",
        'NJ'=>"New Jersey",
        'NM'=>"New Mexico",
        'NY'=>"New York",
        'NC'=>"North Carolina",
        'ND'=>"North Dakota",
        'OH'=>"Ohio",
        'OK'=>"Oklahoma",
        'OR'=>"Oregon",
        'PA'=>"Pennsylvania",
        'RI'=>"Rhode Island",
        'SC'=>"South Carolina",
        'SD'=>"South Dakota",
        'TN'=>"Tennessee",
        'TX'=>"Texas",
        'UT'=>"Utah",
        'VT'=>"Vermont",
        'VA'=>"Virginia",
        'WA'=>"Washington",
        'WV'=>"West Virginia",
        'WI'=>"Wisconsin",
        'WY'=>"Wyoming"
      ];
      if ($any) {
        $states = ['Any' => 'Any'] + $states ;
      }
      return $states;
    }
}
