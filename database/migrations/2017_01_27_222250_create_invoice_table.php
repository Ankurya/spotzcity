<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('integer_id');
            $table->integer('subscription_id')->unsigned()->foreign('subscription_id')->references('id')->on('subscriptions');
            $table->integer('amount_due');
            $table->boolean('attempted');
            $table->timestamp('next_attempt')->nullable();
            $table->boolean('paid');
            $table->string('receipt_number');
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
        Schema::dropIfExists('invoices');
    }
}
