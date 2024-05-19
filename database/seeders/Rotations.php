<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Rotation;
use App\Models\Specialty;

use App\Models\RotationAvailability;

use Carbon\Carbon;

class Rotations extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rotation::query()->delete();

        $faker = \Faker\Factory::create();

        $STATUS = ['draft', 'published'];
        $TYPE = ['inpatient','outpatient','observerships','pre_med_shadowing','virtual_observerships','virtual_shadowing','research','virtual_research'];

        $preceptors = User::where(['role' => 'preceptor'])->get()->random(5)->values();
        for($i=0;$i<count($preceptors);$i++) {
            $cnt = rand(1,5);
            for($k=0;$k<$cnt;$k++) {
                $r = new Rotation();
                $r->preceptor_user_id = $preceptors[$i]['id'];
                $r->preceptor_name = $preceptors[$i]['first_name'].' '.$preceptors[$i]['last_name'];
                $r->hospital_name = $faker->company;
                $r->zipcode = $faker->postcode;
                $r->city = $faker->city;
                $r->state = $faker->stateAbbr;
                $r->price_per_week_in_cents = rand(100,2500) * 100;
                $r->type = $TYPE[rand(0,7)];
                $r->description = $faker->realText();
                $r->status = $STATUS[rand(0,1)];
                $r->save();

                $specialties = Specialty::get()->random(rand(1,2));

                $r->specialties()->attach($specialties);

                for($j=0;$j<30;$j++) {
                    $start = Carbon::now()->addDays(7 * $j)->startOfWeek();
                    if (rand(0,1)==1) {
                        $availability = RotationAvailability::where(['rotation_id' => $r->id, 'starts_at' => $start])->first() ?? new RotationAvailability();
                        $availability->rotation_id = $r->id;
                        $availability->starts_at = $start;
                        $availability->seats = rand(5,15);
                        $availability->status = 'enabled';
                        $availability->save();
                    }
                }        
            }
        }
    }
}
