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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->ipAddress('ip');
            $table->tinyInteger('status')->default('0');
            $table->unsignedBigInteger('parent_id')->nullable()->default(null);
            $table->morphs('commentable');
            $table->nullableMorphs('commentator');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
