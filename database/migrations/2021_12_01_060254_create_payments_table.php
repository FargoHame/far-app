<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('application_id');

            $table->string('hash');

            $table->enum('status', ['draft', 'success', 'processing', 'failed', 'canceled'])
                ->default('draft');

            $table->enum('distribution_status', ['pending', 'paid'])->default('pending');

            $table->timestamps();

            $table->foreign('application_id')->references('id')
                ->on('applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
