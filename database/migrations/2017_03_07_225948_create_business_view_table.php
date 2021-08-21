<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_views', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->unsigned()->foreign('business_id')->references('id')->on('businesses');
            $table->integer('user_id')->unsigned()->nullable()->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('business_views');
    }
}
