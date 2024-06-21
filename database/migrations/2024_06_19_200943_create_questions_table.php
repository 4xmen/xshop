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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->unsignedBigInteger('customer_id');
            $table->text('answer')->default(null)->nullable();
            $table->unsignedBigInteger('product_id');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('product_id')->on('products')
                ->references('id')->onDelete('cascade');
            $table->foreign('customer_id')->on('customers')
                ->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
