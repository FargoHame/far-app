<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotationFileTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotation_file_types', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('rotation_id');
            $table->unsignedBigInteger('file_type_id');

            $table->foreign('rotation_id')->references('id')->on('rotations')->onDelete('cascade');
            $table->foreign('file_type_id')->references('id')->on('file_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rotation_file_types');
    }
}
