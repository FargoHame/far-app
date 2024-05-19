<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotationStudentTypePerCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotation_student_type_per_careers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
    
            $table->unsignedBigInteger('student_type_per_career_id');
            $table->unsignedBigInteger('rotation_id');
    
            $table->foreign('student_type_per_career_id', 'student_type_id')->references('id')->on('student_type_per_careers')->onDelete('cascade');
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
        Schema::dropIfExists('rotation_student_type_per_careers');
    }
}
