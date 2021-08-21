<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('display_name');
            $table->string('email')->unique();
            $table->string('gender')->nullable();
            $table->string('location')->nullable();
            $table->boolean('has_business')->default(false);
            $table->string('picture')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('slug')->index();
            $table->string('e_categories');
            $table->string('e_subcategories');
            $table->string('commodities');
            $table->string('address');
            $table->string('address_two')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('phone')->nullable();
            $table->boolean('for_sale')->default(false)->index();
            $table->string('logo')->nullable();
            $table->string('feature_photos')->nullable();
            $table->string('hours')->nullable();
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
        Schema::drop('users');
        Schema::drop('businesses');
    }
}
