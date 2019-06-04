<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_class_id')->unsigned()->nullable();
            $table->foreign('schedule_class_id')->references('id')->on('schedule_classes')->onDelete('cascade');
            $table->integer('school_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->integer('class_id')->unsigned();
            $table->foreign('class_id')->references('id')->on('grades')->onDelete('cascade');
            $table->string('schedule_type');
            $table->string('name');
            $table->integer('shift')->nullable();
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule_details');
    }
}
