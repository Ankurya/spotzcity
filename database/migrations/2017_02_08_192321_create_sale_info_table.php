<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_info', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->unsigned()->foreign('business_id')->references('id')->on('business');
            $table->string('ein');
            $table->integer('sale_price');
            $table->integer('established');
            $table->integer('gross_income');
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
        Schema::dropIfExists('sale_info');
    }
}
