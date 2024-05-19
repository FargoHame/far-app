<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationRotationAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_rotation_availabilities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('rotation_availability_id');
            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->foreign('rotation_availability_id','r_a_id')->references('id')->on('rotation_availabilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_rotation_availabilities');
    }
}
