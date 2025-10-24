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
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique()->index();
            $table->longText('description');
            $table->string('image')->nullable();
            $table->string('file')->nullable();
            $table->string('ext')->nullable();
            $table->unsignedBigInteger('likes')->default(0);
            $table->boolean('status')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
