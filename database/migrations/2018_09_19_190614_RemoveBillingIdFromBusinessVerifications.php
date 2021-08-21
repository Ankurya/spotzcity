<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveBillingIdFromBusinessVerifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if ( Schema::hasColumn('business_verifications', 'billing_id') ) {
        Schema::table('business_verifications', function (Blueprint $table) {
          $table->dropColumn('billing_id');
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_verifications', function (Blueprint $table) {
          $table->string('billing_id');
        });
    }
}
