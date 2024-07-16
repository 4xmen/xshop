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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->unsignedInteger('visit')->default(1);
            $table->unsignedInteger('browser')->nullable();
            $table->unsignedInteger('os')->nullable();
            $table->string('version')->nullable();
            $table->string('display')->nullable();
            $table->string('keywords')->nullable();
            $table->boolean('is_mobile')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
