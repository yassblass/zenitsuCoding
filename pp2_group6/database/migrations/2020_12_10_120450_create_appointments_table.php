<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id('appointmentId');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->datetime('startsAt');
            $table->string('subject');
            $table->string('status')->default('pending');
            $table->string('cancelToken')->unique();
            $table->timestamps();

            //indexes
            $table->index('student_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
