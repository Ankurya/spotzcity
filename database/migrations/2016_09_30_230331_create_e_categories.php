<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateECategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_categories', function (Blueprint $table) {
          $table->increments('id');
          $table->text('name');
        });

        Schema::create('e_categories_link', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('business_id')->unsigned()->foreign('business_id')->references('id')->on('businesses');
          $table->integer('e_category_id')->unsigned()->foreign('e_category_id')->references('id')->on('e_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('e_categories');
      Schema::dropIfExists('e_categories_link');
    }
}
