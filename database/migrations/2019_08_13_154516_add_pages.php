<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique('slug');
            $table->string('title');
            $table->boolean('active')->default(false);
            $table->boolean('sidebar')->default(true);
            $table->boolean('public')->default(true);
            $table->boolean('show_in_nav')->default(false);
            $table->boolean('show_in_footer')->default(false);
            $table->longText('content')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
