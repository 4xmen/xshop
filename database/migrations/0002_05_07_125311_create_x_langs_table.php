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
        Schema::create('xlangs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tag',7)->unique();
            $table->boolean('rtl')->default(false);
            $table->boolean('is_default')->default(false);
            $table->string('img')->nullable()->default(null);
            $table->string('emoji')->nullable()->default(null);
            $table->tinyInteger('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('x_langs');
    }
};
