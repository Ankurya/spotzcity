<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use SpotzCity\Business;

class AddActiveFlagToBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->boolean('active')->default(0)->index('active');
        });

        // Set all active which are verified
        $verified = Business::where('verified', true)->get();
        $verified->each( function( $business ) {
          $business->active = true;
          $business->save();
        });

        // Delete the rest
        $nonverified = Business::where('verified', false)->get();
        $nonverified->each( function( $business ) {
          $business->delete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
}
