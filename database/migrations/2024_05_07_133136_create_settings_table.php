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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('section');
            $table->enum('type',\App\Models\Setting::$settingTypes);
            $table->string('title');
            $table->boolean('active')->default(true);
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->text('raw')->nullable();
            $table->boolean('ltr')->default(false);
            $table->boolean('is_basic')->default(false);
            $table->boolean('size')->default('12');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
