<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Message;
use App\Models\Application;
use App\Models\Rotation;

class Messages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message::query()->delete();

        $faker = \Faker\Factory::create();

        $applications = Application::get()->random(5)->values();

        for($i=0;$i<count($applications);$i++) {
            for($k=0;$k<5;$k++) {
                $rotation = Rotation::find($applications[$i]->rotation_id);

                $m = new Message();
                $m->application_id = $applications[$i]->id;
                if (rand(0,1)==0) {
                    $m->user_id = $rotation->preceptor_user_id;
                } else {
                    $m->user_id = $applications[$i]->student_user_id;
                }
                $m->message = $faker->realText();
                $m->save();    
            }
        }        
    }
}
