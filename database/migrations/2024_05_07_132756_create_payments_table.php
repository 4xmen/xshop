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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('amount')->nullable();
            $table->enum("type", \App\Models\Payment::$types)->nullable()->default(\App\Models\Payment::$types[0]);
            $table->enum("status", \App\Models\Payment::$status)->nullable()->default(\App\Models\Payment::$status[0]);
            $table->string('order_id')->unique();
            $table->string('reference_id')->nullable();
            $table->text('comment')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
