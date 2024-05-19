<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->string('school')->nullable();
            $table->string('degree')->nullable();
            $table->string('profile_image')->nullable();
            $table->enum('role', ['unknown','student', 'preceptor', 'admin'])->default('unknown');
            $table->enum('status', ['inactive', 'active', 'suspended'])->default('active');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();

            $table->string('oauth_provider')->nullable();
            $table->string('oauth_user_id')->nullable();
            $table->string('oauth_token',1000)->nullable();
            $table->string('oauth_refresh_token',1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
