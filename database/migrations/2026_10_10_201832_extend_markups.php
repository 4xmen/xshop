<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('posts', function (Blueprint $table) {
            $table->text('markups')->nullable()->default(null);
        });
        Schema::table('groups', function (Blueprint $table) {
            $table->text('default_markup')->nullable()->default(null);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->text('markup')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
