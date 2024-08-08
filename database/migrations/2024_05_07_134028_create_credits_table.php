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
        Schema::create('credits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->text('data')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('invoice_id')->references('id')
                ->on('invoices')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')
                ->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credits');
    }
};
