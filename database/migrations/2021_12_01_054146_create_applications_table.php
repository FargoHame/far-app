<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_user_id');
            $table->unsignedBigInteger('rotation_id');
            $table->enum('status', ['pending', 'accepted', 'paid', 'rejected', 'withdrawn'])->default('pending');

            $table->timestamps();
            $table->foreign('student_user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('applications');
    }
}
