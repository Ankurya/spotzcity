<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdClicksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_clicks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ad_id')->unsigned()->foreign('ad_id')->references('id')->on('ads');
            $table->integer('user_id')->unsigned()->nullable()->foreign('user_id')->references('id')->on('users');
            $table->string('page');
            $table->text('metadata')->nullable();
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
        Schema::dropIfExists('ad_clicks');
    }
}
