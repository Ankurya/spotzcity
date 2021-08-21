<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusinessSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billing_id')->unsigned()->references('id')->on('billing');
            $table->string('subscription_item_id')->nullable();
            $table->integer('quantity')->unsigned()->default(0);
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
        Schema::dropIfExists('business_subscriptions');
    }
}
