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
        Schema::disableForeignKeyConstraints();
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->enum("status",\App\Models\Invoice::$invoiceStatus)->nullable()->default("PENDING");
            $table->unsignedBigInteger('total_price')->nullable()->default(0);
            $table->integer('count')->nullable()->default(0);
            $table->json('meta')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable()->default(null);
            $table->text('desc')->nullable()->default(null);
            $table->string('hash',32)->nullable()->default(null)->unique();

            $table->unsignedBigInteger('transport_id')->nullable()->default(null);
            $table->unsignedBigInteger('transport_price')->default(0);
            $table->unsignedBigInteger('credit_price')->default(0);

            $table->boolean('reserve')->default(0);
            $table->unsignedBigInteger('invoice_id')->nullable()->default(null);

            $table->string('address_alt')->default(null)->nullable();
            $table->unsignedBigInteger('address_id')->default(null)->nullable();
            $table->string('tracking_code')->default(null)->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('cascade');
            $table->foreign('transport_id')->references('id')->on('transports')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
