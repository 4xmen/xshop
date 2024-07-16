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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->unsignedInteger('visit')->default(1);
            $table->enum('browser',array_keys(\App\Models\Visitor::$browserList))->nullable();
            $table->enum('os',array_keys(\App\Models\Visitor::$osList))->nullable();
            $table->enum('engine',array_keys(\App\Models\Visitor::$engines))->nullable();
            $table->string('version')->nullable();
            $table->string('display')->nullable();
            $table->string('keywords')->nullable();
            $table->string('referer')->nullable();
            $table->boolean('is_mobile')->default(false);
            $table->string('page')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
