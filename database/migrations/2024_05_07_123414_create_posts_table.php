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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('slug')->unique();
            $table->string('subtitle', 4096);
            $table->text('body');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('status')->default(0);
            $table->boolean('is_breaking')->default(0);
            $table->boolean('is_pinned')->default(0);
            $table->string('hash', 14)->unique();
            $table->unsignedInteger('like')->default(0);
            $table->unsignedInteger('dislike')->default(0);
            $table->string('icon', 128)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->foreign('group_id')
                ->references('id')->on('groups');
        });

        Schema::create('group_post', function (Blueprint $table) {

            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('post_id');

            $table->foreign('group_id')->on('groups')
                ->references('id')->onDelete('cascade');
            $table->foreign('post_id')->on('posts')
                ->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('group_post');
    }
};
