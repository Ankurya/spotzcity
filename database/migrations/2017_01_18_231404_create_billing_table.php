<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->foreign('user_id')->references('id')->on('users');
            $table->string('stripe_id');
            $table->timestamps();
        });

        Schema::create('payment_sources', function(Blueprint $table){
            $table->increments('id');
            $table->integer('billing_id')->unsigned()->foreign('billing_id')->references('id')->on('billing');
            $table->string('card_id');
            $table->string('type');
            $table->string('last_four');
            $table->string('exp_month');
            $table->string('exp_year');
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subscription_id');
            $table->integer('billing_id')->unsigned()->foreign('billing_id')->references('id')->on('billing');
            $table->integer('payment_source_id')->unsigned()->foreign('payment_source_id')->references('id')->on('payment_sources');
            $table->string('type');
            $table->integer('monthly_cost');
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
        Schema::dropIfExists('billing');
        Schema::dropIfExists('payment_sources');
        Schema::dropIfExists('subscriptions');
    }
}
