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
        Schema::create('xlangs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag',7);
            $table->boolean('rtl')->default(false);
            $table->boolean('is_default')->default(false);
            $table->string('img')->nullable()->default(null);
            $table->tinyInteger('sort')->default(0);
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
        Schema::dropIfExists('xlangs');
    }
};
