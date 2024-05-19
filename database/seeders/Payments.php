<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Application;
use App\Models\Payment;

use Illuminate\Support\Str;


class Payments extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::query()->delete();

        $STATUS = ['draft', 'failed', 'canceled'];
        $DISTRIBUTION_STATUS = ['pending', 'paid'];

        $applications = Application::where(['status' => 'paid'])->get()->values();

        for($i=0;$i<count($applications);$i++) {
            $a = new Payment();
            $a->application_id = $applications[$i]['id'];
            $a->user_id = $applications[$i]['student_user_id'];
            $a->status = 'success';
            $a->distribution_status = $DISTRIBUTION_STATUS[rand(0,1)];
            $a->hash = Str::random(40);
            $a->save();
        }

        $applications = Application::where(['status' => 'pending'])->get()->random(2)->values();

        for($i=0;$i<count($applications);$i++) {
            $a = new Payment();
            $a->application_id = $applications[$i]['id'];
            $a->user_id = $applications[$i]['student_user_id'];
            $a->status = $STATUS[rand(0,2)];
            $a->distribution_status = 'pending';
            $a->hash = Str::random(40);
            $a->save();
        }

    }
}
