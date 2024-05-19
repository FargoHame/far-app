<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->string('speciality', 500)->nullable();
            $table->string('company', 30)->nullable();
            $table->json('social_links', 100)->nullable();
            $table->string('location', 20)->nullable();
            $table->json('user_roles')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            Schema::dropIfExists('description');
            Schema::dropIfExists('speciality');
            Schema::dropIfExists('social_links');
            Schema::dropIfExists('location');
            Schema::dropIfExists('company');
            Schema::dropIfExists('user_roles');
        });
    }
}
