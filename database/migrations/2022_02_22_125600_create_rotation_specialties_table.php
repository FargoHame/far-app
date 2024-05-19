<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotationSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotation_specialties', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('specialty_id');
            $table->unsignedBigInteger('rotation_id');

            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade');
            $table->foreign('rotation_id')->references('id')->on('rotations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rotation_specialties');
    }
}
