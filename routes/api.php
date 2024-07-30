<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('', function () {
    return 'xshop api:' . config('app.name');
});

Route::get('/clear', function () {

    if (!auth()->check()) {
        return abort(403);
    }
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Cleared!";

});


Route::prefix('v1')->name('v1.')->group(
    function () {
        Route::get('', function () {
            return 'xShop api v1';
        });

        Route::get('states', [\App\Http\Controllers\Api\StateController::class, 'index'])->name('state.index');
        Route::get('state/{state}', [\App\Http\Controllers\Api\StateController::class, 'show'])->name('state.show');
        Route::get('category/props/{category}', [\App\Http\Controllers\Api\CategoryController::class, 'props'])->name('category.prop');
        Route::post('morph/search', [\App\Http\Controllers\Api\MorphController::class, 'search'])->name('morph.search');
        Route::post('visitor/display', [\App\Http\Controllers\Api\VisitorController::class, 'display'])->name('visitor.display');

        Route::apiResource('web', \App\Http\Controllers\Api\HomeController::class)->only('index');
        Route::apiResource('products' , \App\Http\Controllers\Api\ProductController::class)->only('index');
    });
