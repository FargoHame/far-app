<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Rotation;
use App\Models\Application;
use App\Models\RotationAvailability;

class Applications extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Application::query()->delete();

        $faker = \Faker\Factory::create();

        $STATUS = ['pending', 'accepted', 'paid', 'rejected', 'withdrawn'];

        $students = User::where(['role' => 'student'])->get()->random(10)->values();

        for($i=0;$i<count($students);$i++) {
            $rotation = Rotation::where(['status' => 'published'])->get()->random(1)->values();

            $a = new Application();
            $a->student_user_id = $students[$i]['id'];
            $a->rotation_id = $rotation[0]['id'];
            $a->status = $STATUS[rand(0,4)];
            $a->save();

            $availabilities = RotationAvailability::where(['rotation_id' => $rotation[0]['id']])->get()->random(rand(1,3));
            foreach($availabilities as $availability) {
                $a->rotation_slots()->attach($availability);
            }

        }

    }
}
