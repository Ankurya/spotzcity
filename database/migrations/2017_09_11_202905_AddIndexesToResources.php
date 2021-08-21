<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesToResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_category_links', function (Blueprint $table) {
            $table->index('resource_id');
            $table->index('resource_category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_category_links', function (Blueprint $table) {
            $table->dropIndex('resource_id');
            $table->dropIndex('resource_category_id');
        });
    }
}
