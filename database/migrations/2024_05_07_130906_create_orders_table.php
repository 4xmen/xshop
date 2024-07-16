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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('quantity_id')->nullable();
            $table->integer('count')->nullable()->default(1);
            $table->unsignedInteger('price_total');
            $table->json('data')->nullable()->default(null);;
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')
                ->on('invoices')->onDelete('cascade');
//            $table->foreign('quantity_id')->references('id')->on('quantities')->onDelete('cascade');
            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
