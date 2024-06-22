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
        Schema::create('props', function (Blueprint $table) {
            $table->id();
            $table->string('name',90)->unique();
            $table->text('label');
            $table->string('width',300)->default('col-md-6');
            $table->boolean('required')->default(false);
            $table->boolean('searchable')->default(true);
            $table->string('type',60);
            $table->text('unit')->nullable()->default('');
            $table->unsignedInteger('sort')->default(null)->nullable();
            $table->longText('options')->nullable();
            $table->boolean('priceable')->default(false);
            $table->string('icon',128)->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('category_prop', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('prop_id');
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
            $table->foreign('prop_id')->on('props')->references('id')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('props');
        Schema::dropIfExists('category_prop');
    }
};
