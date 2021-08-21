<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostcardIdExpectedArrivalNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_verifications', function (Blueprint $table) {
          $table->string('postcard_id')->nullable()->change();
          $table->date('expected_arrival')->nullable()->change();
          $table->string('verification_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_verifications', function (Blueprint $table) {
          $table->string('postcard_id')->change();
          $table->date('expected_arrival')->change();
          $table->dropColumn('verification_code');
        });
    }
}
