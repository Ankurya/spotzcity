<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('business_hours', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('business_id')->unsigned()->foreign('business_id')->references('id')->on('businesses');
        $table->timeTz('mon_open')->nullable();
        $table->timeTz('mon_close')->nullable();
        $table->timeTz('tue_open')->nullable();
        $table->timeTz('tue_close')->nullable();
        $table->timeTz('wed_open')->nullable();
        $table->timeTz('wed_close')->nullable();
        $table->timeTz('thu_open')->nullable();
        $table->timeTz('thu_close')->nullable();
        $table->timeTz('fri_open')->nullable();
        $table->timeTz('fri_close')->nullable();
        $table->timeTz('sat_open')->nullable();
        $table->timeTz('sat_close')->nullable();
        $table->timeTz('sun_open')->nullable();
        $table->timeTz('sun_close')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('business_hours');
    }
}
