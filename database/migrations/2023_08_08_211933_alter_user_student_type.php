<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserStudentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('career_id')->nullable();
            $table->unsignedBigInteger('student_type_per_careers_id')->nullable();
            $table->foreign('career_id')->references('id')->on('careers')->onDelete('cascade');
            $table->foreign('student_type_per_careers_id')->references('id')->on('student_type_per_careers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('career_id');
            Schema::dropIfExists('student_type_per_careers_id');
        });
    }
}
