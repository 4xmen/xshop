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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->enum('type',\App\Models\Discount::$doscount_type);
            $table->string('code',100)->nullable()->default(null);
            $table->unsignedBigInteger('amount');
            $table->dateTime('expire')->default(null)->nullable();
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('product_id')->on('products')
                ->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
