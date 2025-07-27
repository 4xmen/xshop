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
        Schema::create('creators', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('slug', 128)->unique();
            $table->text('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('image', 2048)->nullable();
            $table->unsignedInteger('parent_id')->nullable()->default(null)->index();
            $table->text('canonical')->nullable();
            $table->integer('sort')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('creator_product', function (Blueprint $table) {

            $table->unsignedBigInteger('creator_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('product_id')->on('products')
                ->references('id')->onDelete('cascade');

            $table->foreign('creator_id')->on('creators')
                ->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creators');
        Schema::dropIfExists('creator_product');
    }
};
