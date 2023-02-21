<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarterKitTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('slug', 128)->unique();
            $table->text('description')->nullable();
            $table->integer('sort')->default(0);
            $table->unsignedInteger('parent_id')->nullable()->default(null)->index();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subtitle', 4096);
            $table->text('body');
            $table->unsignedBigInteger('category_id');
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
            $table->foreign('category_id')
                ->references('id')->on('categories');
        });

        Schema::create('category_post', function (Blueprint $table) {

            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('post_id');

            $table->foreign('category_id')->on('categories')
                ->references('id')->onDelete('cascade');
            $table->foreign('post_id')->on('posts')
                ->references('id')->onDelete('cascade');
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->string('name', 60);
            $table->string('email', 100);
            $table->ipAddress('ip');
            $table->tinyInteger('status')->default('0');
            $table->unsignedBigInteger('sub_comment_id')->nullable()->default(null);
            $table->morphs('commentable');
            $table->timestamps();
        });

        Schema::create('admin_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('action');
            $table->morphs('loggable');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users');
        });
        Schema::create('guest_logs', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->string('action');
            $table->morphs('loggable');
            $table->timestamps();
        });

        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_id');
            $table->unsignedBigInteger('user_id');
            $table->string('title')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('gallery_id')
                ->references('id')->on('galleries');
        });

        Schema::create('polls', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->unsignedBigInteger('user_id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users');
        });
        Schema::create('opinions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('poll_id');
            $table->string('title');
            $table->unsignedBigInteger('vote')->default(0);
            $table->timestamps();

            $table->foreign('poll_id')
                ->references('id')->on('polls');
        });

        Schema::create('clips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body')->nullable();
            $table->string('file', 2048)->nullable();
            $table->string('cover', 2048)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users');
        });

        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->string('image');
            $table->unsignedBigInteger('user_id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users');
        });
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
        });

        Schema::create('advs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamp('expire');
            $table->string('image');
            $table->unsignedInteger('max_click')->default(0);
            $table->unsignedInteger('click')->default(0);
            $table->boolean('active')->default(true);
            $table->string('link');
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
        });

        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
//            $table->morphs('menuable')->nullable();;
            $table->unsignedBigInteger('menuable_id')->nullable();
            $table->string('menuable_type')->nullable();
            $table->string('kind')->nullable();
            $table->text('meta')->nullable();
            $table->unsignedInteger('parent')->nullable()->default(null)->index();
            $table->unsignedInteger('sort')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('menu_id');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('menu_id')
                ->references('id')->on('menus');
        });

	Schema::table('users', function (Blueprint $table) {
	    $table->string('mobile',15)->nullable()->default(null);
	});

    }
}
