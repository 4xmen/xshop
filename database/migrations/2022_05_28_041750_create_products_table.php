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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->longText('description')->nullable();
            $table->text('excerpt')->nullable()->comment('Quick summary for product. This will appear on the product page under the product name and for SEO purpose.');
            $table->string('sku')->nullable()->unique()->comment('SKU refers to a Stock-keeping unit, a unique identifier for each distinct product and service that can be purchased.');
            $table->boolean('virtual')->nullable()->default(false)->index()->comment('If this product is a non-physical item, for example a service, which does not need shipping.');
            $table->boolean('downloadable')->nullable()->default(false)->index()->comment('If purchasing this product gives a customer access to a downloadable file, e.g. software');
            $table->unsignedBigInteger('price')->nullable()->default(null)->index();
            $table->unsignedBigInteger('cat_id')->comment('main category id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('on_sale')->nullable()->default(true)->index();
            $table->unsignedBigInteger('stock_quantity')->nullable()->default(0);
            $table->enum('stock_status',['IN_STOCK','OUT_STOCK','BACK_ORDER'])->nullable()->default('IN_STOCK')->index();
            $table->unsignedBigInteger('rating_count')->nullable()->default(0);
            $table->unsignedDecimal('average_rating',3,2)->nullable()->default(0.00);
            $table->unsignedBigInteger('total_sales')->nullable()->default(0);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('sell_count')->default(0);
            $table->unsignedTinyInteger('image_index')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('cat_id')
                ->references('id')->on('cats');
        });

        Schema::create('cat_product', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('cat_id')->on('cats')->references('id')->onDelete('cascade');
            $table->foreign('product_id')->on('products')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('cat_product');
    }
};
