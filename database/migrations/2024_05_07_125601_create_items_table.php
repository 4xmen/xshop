<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->text('title');
//            $table->morphs('menuable')->nullable();;
            $table->unsignedBigInteger('menuable_id')->nullable();
            $table->string('menuable_type')->nullable();
            $table->string('kind')->nullable();
            $table->text('meta')->nullable();
            $table->unsignedInteger('parent')->nullable()->default(null)->index();
            $table->unsignedInteger('sort')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('menu_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('menu_id')
                ->references('id')->on('menus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
