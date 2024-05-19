<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rotations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('preceptor_user_id');

            $table->string('preceptor_name');
            $table->string('hospital_name');

            $table->string('zipcode');
            $table->string('city');
            $table->string('state');
            $table->integer('price_per_week_in_cents');
            $table->enum('type', ['inpatient','outpatient','observerships','pre_med_shadowing','virtual_observerships','virtual_shadowing','research','virtual_research']);
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'published', 'disabled', 'archived'])->default('draft');

            $table->timestamps();

            $table->foreign('preceptor_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rotations');
    }
}
