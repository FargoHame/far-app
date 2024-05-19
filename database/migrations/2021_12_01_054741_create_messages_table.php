<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('user_id');

            $table->text('message');
            // if a user sees the message, if user_id!=viewed_user_id && user_type!='admin', set the viewed_at to current timestamp
            $table->timestamp('viewed_at')->nullable();

            $table->timestamps();

            $table->foreign('application_id')->references('id')->on('applications')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
