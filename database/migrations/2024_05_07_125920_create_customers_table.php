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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable()->default(null);
            $table->string('email')->unique()->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable()->default(null);
            $table->string('password')->nullable()->default(null);

            $table->string('mobile',15)->unique()->nullable()->default(null);
            $table->date('dob')->nullable()->default(null);
            $table->string('sms',10)->nullable()->default(null);
            $table->string('code',10)->nullable()->default(null);
            $table->boolean('colleague')->default(false);
            $table->text('description')->default(null)->nullable();
            $table->bigInteger('credit')->default(0);
            $table->enum('sex',['MALE','FEMALE'])->nullable()->default(null);
            $table->integer('height')->nullable()->default(null);
            $table->decimal('weight')->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->json('card')->default(null)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
