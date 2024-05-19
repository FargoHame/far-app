<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::query()->delete();

        $user = new User([
            'first_name' => 'Sandaruwan',
            'last_name' => 'Gunathilake',
            'password' => Hash::make('password'),
            'email' => 'sandaruwan@medicaljoyworks.com'
        ]);
        $user->status = 'active';
        $user->email_verified_at = now();
        $user->role = 'admin';
        $user->last_login_at = now();
        $user->save();

        $this->call(HardcodedData::class);

        $this->call(Students::class);
        $this->call(Preceptors::class);
        $this->call(Rotations::class);
        $this->call(Applications::class);
        $this->call(Messages::class);
        $this->call(Payments::class);
        
        // \App\Models\User::factory(10)->create();
    }
}
