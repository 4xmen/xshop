<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('posts', function ($table) {
            $table->text('title')->change();
        });
        Schema::table('categories', function ($table) {
            $table->text('name')->change();
        });
        Schema::table('cats', function ($table) {
            $table->text('name')->change();
        });
        Schema::table('products', function ($table) {
            $table->text('name')->change();
        });
        Schema::table('props', function ($table) {
            $table->text('label')->change();
        });
        Schema::table('galleries', function ($table) {
            $table->text('title')->change();
        });
        Schema::table('menu_items', function ($table) {
            $table->text('title')->change();
        });
        Schema::table('images', function ($table) {
            $table->text('title')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
