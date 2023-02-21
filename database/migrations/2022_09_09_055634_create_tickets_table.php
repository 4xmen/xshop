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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title',128)->nullable()->default(null);
            $table->unsignedBigInteger('customer_id');
            $table->text('body');
            $table->enum('status',['PENDING','ANSWERED','CLOSED'])->default('PENDING');
            $table->text('answer')->nullable()->default(null);
            $table->unsignedInteger('parent_id')->nullable()->default(null)->index();
            $table->timestamps();
            $table->foreign('customer_id')->on('customers')
                ->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
