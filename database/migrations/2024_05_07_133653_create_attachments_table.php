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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('slug')->unique();
            $table->text('subtitle');
            $table->text('body');
            $table->string('file',2048)->nullable();
            $table->string('ext')->nullable();
            $table->unsignedBigInteger('downloads')->default(0)->comment('downloads count');
            $table->boolean('is_fillable')->default(true);
            $table->unsignedBigInteger('size')->default(0);
            $table->nullableMorphs('attachable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
