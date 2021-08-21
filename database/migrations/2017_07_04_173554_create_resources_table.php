<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('website');
            $table->string('city');
            $table->string('state');
            $table->string('phone')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });

        Schema::create('resource_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('resource_category_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resource_id')->unsigned()->foreign('resource_id')->references('id')->on('resources');
            $table->integer('resource_category_id')->unsigned()->foreign('resource_category_id')->references('id')->on('resource_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
