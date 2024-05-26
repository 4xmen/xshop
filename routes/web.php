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
                Route::prefix('users')->name('user.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
                        Route::get('edit/{user}', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
                        Route::get('show/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');
                        Route::post('update/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
                        Route::get('delete/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [\App\Http\Controllers\Admin\UserController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\UserController::class, "trashed"])->name('trashed');
                    });
            });
    });
