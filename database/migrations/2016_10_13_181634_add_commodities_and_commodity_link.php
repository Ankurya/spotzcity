<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommoditiesAndCommodityLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
          $table->increments('id');
          $table->text('name');
        });

        Schema::create('commodity_links', function(Blueprint $table){
          $table->increments('id');
          $table->integer('business_id')->unsigned()->foreign('business_id')->references('id')->on('businesses');
          $table->integer('commodity_id')->unsigned()->foreign('commodity_id')->references('id')->on('commodities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('commodities');
      Schema::dropIfExists('commodity_links');
    }
}
