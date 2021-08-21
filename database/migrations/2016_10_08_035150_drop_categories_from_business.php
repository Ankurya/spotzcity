<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCategoriesFromBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function (Blueprint $table) {
          $table->dropColumn('e_categories');
          $table->dropColumn('e_subcategories');
          $table->dropColumn('commodities');
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
          $table->string('e_categories');
          $table->string('e_subcategories');
          $table->string('commodities');
        });
    }
}
