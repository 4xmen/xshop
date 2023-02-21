<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('amount')->nullable();
            $table->enum("type", ['ONLINE', 'CHEQUE', 'CASH', 'CARD', 'CASH_ON_DELIVERY',])->nullable()->default("ONLINE");
            $table->enum("status", ['PENDING','SUCCESS', 'FAIL','CANCEL'])->nullable()->default("PENDING");
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
