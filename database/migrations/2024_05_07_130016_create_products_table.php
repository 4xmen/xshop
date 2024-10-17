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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();
            $table->longText('table')->nullable();
            $table->text('excerpt')->nullable()->comment('Quick summary for product. This will appear on the product page under the product name and for SEO purpose.');
            $table->string('sku')->nullable()->unique()->comment('SKU refers to a Stock-keeping unit, a unique identifier for each distinct product and service that can be purchased.');
            $table->boolean('virtual')->nullable()->default(false)->index()->comment('If this product is a non-physical item, for example a service, which does not need shipping.');
            $table->boolean('downloadable')->nullable()->default(false)->index()->comment('If purchasing this product gives a customer access to a downloadable file, e.g. software');
            $table->unsignedBigInteger('price')->nullable()->default(null)->index();
            $table->unsignedBigInteger('buy_price')->default(0)->comment('bye price to calculate your Gross Margin');
            $table->unsignedBigInteger('category_id')->comment('main category id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('on_sale')->nullable()->default(true)->index();
            $table->unsignedBigInteger('stock_quantity')->nullable()->default(0);
            $table->enum('stock_status',\App\Models\Product::$stock_status)->nullable()->default(\App\Models\Product::$stock_status[0])->index();
            $table->unsignedBigInteger('rating_count')->nullable()->default(0);
            $table->decimal('average_rating',3,2)->unsigned()->nullable()->default(0.00);
//            $table->unsignedBigInteger('total_sales')->nullable()->default(0);
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedBigInteger('view')->default(0);
            $table->unsignedBigInteger('sell')->default(0);
            $table->unsignedTinyInteger('image_index')->default(0);
            $table->json('theme')->nullable();
            $table->text('canonical')->nullable();
            $table->string('promote')->nullable();
            $table->text('keyword')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('category_id')
                ->references('id')->on('categories');
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('category_product');
    }
};
