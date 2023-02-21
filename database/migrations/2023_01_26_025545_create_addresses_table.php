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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->text('address');
            $table->unsignedBigInteger('customer_id');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->unsignedInteger('state')->nullable()->default(null);
            $table->unsignedInteger('city')->nullable()->default(null);
            $table->json('data');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('customer_id')->references('id')
                ->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
