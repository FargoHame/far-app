<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Students extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        User::where(['role' => 'student'])->delete();

        for($i=0;$i<10;$i++) {
            $user = new User([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'password' => Hash::make('password'),
                'email' => $faker->email
            ]);
            $user->status = 'active';
            $user->email_verified_at = now();
            $user->role = 'student';
            $user->last_login_at = now();
            $user->save();
        }  
    }
}
