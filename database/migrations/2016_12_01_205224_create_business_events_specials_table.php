<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessEventsSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->unsigned()->foreign('business_id')->references('id')->on('businesses');
            $table->string('name');
            $table->string('price')->nullable();
            $table->text('description')->nullable();
            $table->datetime('start')->nullable();
            $table->datetime('end')->nullable();
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
        Schema::dropIfExists('business_events');
    }
}
