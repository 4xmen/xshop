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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('slug', 128)->unique();
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 2048)->nullable();
            $table->string('bg', 2048)->nullable();
            $table->integer('sort')->default(0);
            $table->unsignedInteger('parent_id')->nullable()->default(null)->index();
            $table->json('theme')->nullable();
            $table->text('canonical')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
