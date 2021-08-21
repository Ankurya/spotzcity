<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('user_id')->unsigned()->nullable()->foreign('user_id')->references('id')->on('users');
            $table->integer('business_id')->unsigned()->nullable()->foreign('business_id')->references('id')->on('businesses');
            $table->integer('review_id')->unsigned()->nullable()->foreign('review_id')->references('id')->on('review');
            $table->integer('business_event_id')->unsigned()->nullable()->foreign('business_event_id')->references('id')->on('business_events');
            $table->integer('review_response_id')->unsigned()->nullable()->foreign('review_response_id')->references('id')->on('review_responses');
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
        Schema::dropIfExists('activity');
    }
}
