<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_category_links', function (Blueprint $table) {
            $table->index('business_id');
            $table->index('e_category_id');
        });

        Schema::table('commodity_links', function (Blueprint $table) {
            $table->index('business_id');
            $table->index('commodity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_category_links', function (Blueprint $table) {
            $table->dropIndex('business_id');
            $table->dropIndex('e_category_id');
        });

        Schema::table('commodity_links', function (Blueprint $table) {
            $table->dropIndex('business_id');
            $table->dropIndex('commodity_id');
        });
    }
}
