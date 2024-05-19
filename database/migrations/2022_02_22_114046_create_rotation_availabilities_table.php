<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotationAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotation_availabilities', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('rotation_id');
            $table->date('starts_at');
            $table->integer('seats');

            $table->enum('status', ['enabled', 'disabled'])->default('enabled');

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
        Schema::dropIfExists('rotation_availabilities');
    }
}
