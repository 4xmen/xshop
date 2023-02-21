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
        Schema::create('props', function (Blueprint $table) {
                $table->id();
                $table->string('name',90)->unique();
                $table->string('label',90);
                $table->string('width',300)->default('col-md-6');
                $table->boolean('required')->default(false);
                $table->boolean('searchable')->default(true);
                $table->string('type',60);
                $table->string('unit',50)->nullable()->default('');
                $table->unsignedInteger('sort')->default(null)->nullable();
                $table->longText('options')->nullable();
                $table->boolean('priceable')->default(false);
                $table->string('icon',128)->nullable()->default(null);
                $table->timestamps();
                $table->softDeletes();
        });
        Schema::create('cat_prop', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('prop_id');
            $table->foreign('cat_id')->on('cats')->references('id')->onDelete('cascade');
            $table->foreign('prop_id')->on('props')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('props');
        Schema::dropIfExists('cat_prop');
    }
};
