<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateNewAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a admin member';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $values = array();
      $values['first_name'] = $this->ask('First name of the user');
      $values['last_name'] = $this->ask('Last name of the user');
      $values['email'] = $this->ask('Email');
      $values['password'] = Hash::make($this->secret('What is the password?'));

      $user = new User($values);
      $user->status = 'active';
      $user->email_verified_at = now();
      $user->role = 'admin';
      $user->save();

      return 0;
    }
}
