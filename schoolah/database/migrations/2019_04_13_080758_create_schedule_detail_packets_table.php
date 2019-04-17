<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleDetailPacketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_detail_packets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('packet_id')->unsigned();
            $table->foreign('packet_id')->references('id')->on('packets')->onDelete('cascade');
            $table->integer('schedule_detail_id')->unsigned();
            $table->foreign('schedule_detail_id')->references('id')->on('schedule_details')->onDelete('cascade');
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
        Schema::dropIfExists('schedule_detail_packets');
    }
}
