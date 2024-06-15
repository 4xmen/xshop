<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix(config('app.panel.prefix'))->name('admin.')->group(
    function () {
        Route::group(
            ['middleware' => ['auth']],
            function () {


                Route::get('/',[\App\Http\Controllers\HomeController::class,'index'])->name('dash');

                Route::post('ckeditor/upload', [\App\Http\Controllers\Admin\CkeditorController::class,'upload'])->name('ckeditor.upload');
                Route::get('adminlogs', [\App\Http\Controllers\Admin\AdminLogController::class,'index'])->name('adminlog.index');
                Route::get('adminlogs/{user}', [\App\Http\Controllers\Admin\AdminLogController::class,'log'])->name('adminlog.show');
                Route::post('images/store/{gallery}', [\App\Http\Controllers\Admin\ImageController::class,'store'])->name('image.store');
                Route::get('images/destroy/{image}', [\App\Http\Controllers\Admin\ImageController::class,'destroy'])->name('image.destroy');


                Route::prefix('users')->name('user.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
                        Route::get('log/{item}', [\App\Http\Controllers\Admin\AdminLogController::class, 'log'])->name('log');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\UserController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\UserController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\UserController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('groups')->name('group.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\GroupController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\GroupController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\GroupController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\GroupController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\GroupController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('categories')->name('category.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\CategoryController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\CategoryController::class, "trashed"])->name('trashed');
                    });

                Route::prefix('posts')->name('post.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\PostController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\PostController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\PostController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\PostController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\PostController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\PostController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\PostController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\PostController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\PostController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\PostController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('clips')->name('clip.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\ClipController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\ClipController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\ClipController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\ClipController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\ClipController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\ClipController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\ClipController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\ClipController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\ClipController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\ClipController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('galleries')->name('gallery.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\GalleryController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\GalleryController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\GalleryController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\GalleryController::class, 'show'])->name('show');
                        Route::post('title/update', [\App\Http\Controllers\Admin\GalleryController::class, 'updateTitle'])->name('title');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\GalleryController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\GalleryController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\GalleryController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [\App\Http\Controllers\Admin\GalleryController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('sliders')->name('slider.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\SliderController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\SliderController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\SliderController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\SliderController::class, 'show'])->name('show');
                        Route::post('title/update', [\App\Http\Controllers\Admin\SliderController::class, 'updateTitle'])->name('title');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\SliderController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\SliderController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [\App\Http\Controllers\Admin\SliderController::class, "bulk"])->name('bulk');
                    });
            });
    });
