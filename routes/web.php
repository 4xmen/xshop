<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix(config('app.panel.prefix'))->name('admin.')->group(
    function () {
        Route::group(
            ['middleware' => ['auth']],
            function () {


                Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

                Route::get('adminlogs', [\App\Http\Controllers\Admin\AdminLogController::class, 'index'])->name('adminlog.index');
                Route::get('adminlogs/{user}', [\App\Http\Controllers\Admin\AdminLogController::class, 'log'])->name('adminlog.show');
                Route::post('ckeditor/upload', [\App\Http\Controllers\Admin\CkeditorController::class, 'upload'])->name('ckeditor.upload');
                Route::get('guestlog', [\App\Http\Controllers\Admin\GuestLogController::class, 'index'])->name('guestlog.index');
                Route::post('images/store/{gallery}', [\App\Http\Controllers\Admin\ImageController::class, 'store'])->name('image.store');
                Route::get('images/destroy/{image}', [\App\Http\Controllers\Admin\ImageController::class, 'destroy'])->name('image.destroy');
                Route::any('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
                Route::get('rates', [\App\Http\Controllers\Admin\RateController::class, 'index'])->name('rate.index');


                Route::prefix('addresses')->name('address.')->group(
                    function () {
                        Route::get('customer/{item?}', [\App\Http\Controllers\Admin\AddressController::class, 'customer'])->name('customer');
                        Route::post('add/{item?}', [\App\Http\Controllers\Admin\AddressController::class, 'store'])->name('store');
                        Route::post('update/{item?}', [\App\Http\Controllers\Admin\AddressController::class, 'update'])->name('update');
                        Route::get('destroy/{item?}', [\App\Http\Controllers\Admin\AddressController::class, 'destroy'])->name('destroy');
                    });
                Route::prefix('adv')->name('adv.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\AdvController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\AdvController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\AdvController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\AdvController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\AdvController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\AdvController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\AdvController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\AdvController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\AdvController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\AdvController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('area')->name('area.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\AreaController::class, "index"])->name('index');
                        Route::get('design/{area}', [\App\Http\Controllers\Admin\AreaController::class, "design"])->name('design');
                        Route::get('design/model/{area?}/{model?}/{id?}', [\App\Http\Controllers\Admin\AreaController::class, "designModel"])->name('design.model');
                        Route::get('image/{segment?}/{part?}', [\App\Http\Controllers\Admin\AreaController::class, "image"])->name('image');
//                        Route::post('store', [\App\Http\Controllers\Admin\SettingController::class, "store"])->name('store');
                        Route::post('update/{area}', [\App\Http\Controllers\Admin\AreaController::class, "update"])->name('update');
                        Route::post('update/model/{model?}/{id?}', [\App\Http\Controllers\Admin\AreaController::class, "updateModel"])->name('update.model');
                        Route::get('sort/{area?}', [\App\Http\Controllers\Admin\AreaController::class, "sort"])->name('sort');
                        Route::get('build', [\App\Http\Controllers\Admin\AreaController::class, "build"])->name('build');
                        Route::get('guide', [\App\Http\Controllers\Admin\AreaController::class, "guide"])->name('guide');
                        Route::post('sort-save/{area?}', [\App\Http\Controllers\Admin\AreaController::class, "sortSave"])->name('sort-save');
                    }
                );

                Route::prefix('attachments')->name('attachment.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\AttachmentController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\AttachmentController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\AttachmentController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\AttachmentController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\AttachmentController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\AttachmentController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\AttachmentController::class, 'destroy'])->name('destroy');
                        Route::get('premium/toggle/{item?}', [\App\Http\Controllers\Admin\AttachmentController::class, 'togglePremium'])->name('toggle-premium');
                        Route::get('detach/{item?}', [\App\Http\Controllers\Admin\AttachmentController::class, 'detach'])->name('detach');
                        Route::post('bulk', [\App\Http\Controllers\Admin\AttachmentController::class, "bulk"])->name('bulk');
                        Route::post('attaching', [\App\Http\Controllers\Admin\AttachmentController::class, "attaching"])->name('attaching');
                    });
                Route::prefix('categories')->name('category.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('show');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\CategoryController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\CategoryController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\CategoryController::class, "trashed"])->name('trashed');
                        Route::post('sort/save', [\App\Http\Controllers\Admin\CategoryController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [\App\Http\Controllers\Admin\CategoryController::class, 'sort'])->name('sort');
                    });
                Route::prefix('cities')->name('city.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\CityController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\CityController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\CityController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\CityController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\CityController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\CityController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\CityController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\CityController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\CityController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\CityController::class, "trashed"])->name('trashed');
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
                Route::prefix('contacts')->name('contact.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('index');
//                        Route::get('create', [\App\Http\Controllers\Admin\TicketController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\ContactController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('show');
                        Route::post('reply/{item}', [\App\Http\Controllers\Admin\ContactController::class, 'reply'])->name('reply');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [\App\Http\Controllers\Admin\ContactController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('comments')->name('comment.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\CommentController::class, 'index'])->name('index');
                        Route::get('status/{item}/{status}', [\App\Http\Controllers\Admin\CommentController::class, 'status'])->name('status');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('destroy');
                        Route::get('reply/{item}', [\App\Http\Controllers\Admin\CommentController::class, 'reply'])->name('reply');
                        Route::post('replying/{item}', [\App\Http\Controllers\Admin\CommentController::class, 'replying'])->name('replying');
                        Route::post('bulk', [\App\Http\Controllers\Admin\CommentController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('customers')->name('customer.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\CustomerController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\CustomerController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\CustomerController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\CustomerController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\CustomerController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\CustomerController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\CustomerController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\CustomerController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('discounts')->name('discount.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\DiscountController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\DiscountController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\DiscountController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\DiscountController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\DiscountController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\DiscountController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\DiscountController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\DiscountController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\DiscountController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('evaluations')->name('evaluation.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\EvaluationController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\EvaluationController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\EvaluationController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\EvaluationController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\EvaluationController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\EvaluationController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\EvaluationController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\EvaluationController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\EvaluationController::class, "trashed"])->name('trashed');
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
                Route::prefix('gfx')->name('gfx.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\GfxController::class, "index"])->name('index');
//                        Route::post('store', [\App\Http\Controllers\Admin\SettingController::class, "store"])->name('store');
                        Route::post('update', [\App\Http\Controllers\Admin\GfxController::class, "update"])->name('update');
                    }
                );
                Route::prefix('groups')->name('group.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\GroupController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\GroupController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\GroupController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'update'])->name('update');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'show'])->name('show');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\GroupController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\GroupController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\GroupController::class, "trashed"])->name('trashed');
                        Route::post('sort/save', [\App\Http\Controllers\Admin\GroupController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [\App\Http\Controllers\Admin\GroupController::class, 'sort'])->name('sort');
                    });
                Route::prefix('creator')->name('creator.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\CreatorController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\CreatorController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\CreatorController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\CreatorController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\CreatorController::class, 'update'])->name('update');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\CreatorController::class, 'show'])->name('show');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\CreatorController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\CreatorController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\CreatorController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\CreatorController::class, "trashed"])->name('trashed');
                        Route::post('sort/save', [\App\Http\Controllers\Admin\CreatorController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [\App\Http\Controllers\Admin\CreatorController::class, 'sort'])->name('sort');
                    });
                Route::prefix('invoices')->name('invoice.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('index');
//                        Route::get('create', [\App\Http\Controllers\Admin\InvoiceController::class, 'create'])->name('create');
//                        Route::post('store', [\App\Http\Controllers\Admin\InvoiceController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\InvoiceController::class, 'edit'])->name('edit');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\InvoiceController::class, 'show'])->name('show');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\InvoiceController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\InvoiceController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\InvoiceController::class, 'restore'])->name('restore');
                        Route::get('remove/ordere/{order}', [\App\Http\Controllers\Admin\InvoiceController::class, 'removeOrder'])->name('remove-order');
                        Route::post('bulk', [\App\Http\Controllers\Admin\InvoiceController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\InvoiceController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('langs')->name('lang.')->group(
                    function () {
                        Route::get('/', [\App\Http\Controllers\Admin\XLangController::class, 'index'])->name('index');
                        Route::get('/translates', [\App\Http\Controllers\Admin\XLangController::class, 'translate'])->name('translate');
                        Route::get('/delete/{item}', [\App\Http\Controllers\Admin\XLangController::class, 'destroy'])->name('delete');
                        Route::get('/create', [\App\Http\Controllers\Admin\XLangController::class, 'create'])->name('create');
                        Route::post('/store', [\App\Http\Controllers\Admin\XLangController::class, 'store'])->name('store');
                        Route::get('/edit/{item}', [\App\Http\Controllers\Admin\XLangController::class, 'edit'])->name('edit');
                        Route::post('/update/{item}', [\App\Http\Controllers\Admin\XLangController::class, 'update'])->name('update');
                        Route::post('bulk', [\App\Http\Controllers\Admin\XLangController::class, "bulk"])->name('bulk');
                        Route::get('/download/{tag}', [\App\Http\Controllers\Admin\XLangController::class, 'download'])->name('download');
                        Route::get('/ai/{tag}', [\App\Http\Controllers\Admin\XLangController::class, 'ai'])->name('ai');
                        Route::get('/online/edit/{tag}', [\App\Http\Controllers\Admin\XLangController::class, 'onlineEdit'])->name('onlineEdit');
                        Route::post('/save/edit/{tag}', [\App\Http\Controllers\Admin\XLangController::class, 'editSave'])->name('editSave');
                        Route::post('/batch', [\App\Http\Controllers\Admin\XLangController::class, 'batch'])->name('batch');
                        Route::post('/upload/{tag}', [\App\Http\Controllers\Admin\XLangController::class, 'upload'])->name('upload');
                        Route::get('/model/translate/{id}/{model}', [\App\Http\Controllers\Admin\XLangController::class, 'translateModel'])->name('model');
                        Route::post('/model/translate/save/{id}/{model}', [\App\Http\Controllers\Admin\XLangController::class, 'translateModelSave'])->name('modelSave');
                        Route::get('/model/ai/{id}/{model}/{field}/{lang}', [\App\Http\Controllers\Admin\XLangController::class, 'translateModelAi'])->name('aiText');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\XLangController::class, 'restore'])->name('restore');
                        Route::get('trashed', [\App\Http\Controllers\Admin\XLangController::class, "trashed"])->name('trashed');

                    });
                Route::prefix('menus')->name('menu.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\MenuController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\MenuController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\MenuController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\MenuController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\MenuController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\MenuController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\MenuController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\MenuController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\MenuController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\MenuController::class, "trashed"])->name('trashed');
                        Route::post('sort/save', [\App\Http\Controllers\Admin\MenuController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort/{item}', [\App\Http\Controllers\Admin\MenuController::class, 'sort'])->name('sort');
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
                        Route::get('group/edit/{id?}', [\App\Http\Controllers\Admin\PostController::class, 'groupEdit'])->name('group-edit');
                        Route::post('group/save/{item?}', [\App\Http\Controllers\Admin\PostController::class, 'groupSave'])->name('group-save');
                    });
                Route::prefix('products')->name('product.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\ProductController::class, 'show'])->name('show');
                        Route::post('title/update', [\App\Http\Controllers\Admin\ProductController::class, 'updateTitle'])->name('title');
                        Route::get('edit/{item?}', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('edit');
                        Route::post('update/{item?}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\ProductController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\ProductController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\ProductController::class, "trashed"])->name('trashed');
                        Route::get('category/edit/{id?}', [\App\Http\Controllers\Admin\ProductController::class, 'categoryEdit'])->name('category-edit');
                        Route::post('category/save/{item?}', [\App\Http\Controllers\Admin\ProductController::class, 'categorySave'])->name('category-save');

                    });
                Route::prefix('props')->name('prop.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\PropController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\PropController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\PropController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\PropController::class, 'show'])->name('show');
                        Route::post('title/update', [\App\Http\Controllers\Admin\PropController::class, 'updateTitle'])->name('title');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\PropController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\PropController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\PropController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\PropController::class, 'restore'])->name('restore');

                        Route::post('bulk', [\App\Http\Controllers\Admin\PropController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\PropController::class, "trashed"])->name('trashed');

                        Route::post('sort/save', [\App\Http\Controllers\Admin\PropController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [\App\Http\Controllers\Admin\PropController::class, 'sort'])->name('sort');
                    });




                Route::prefix('redirects')->name('redirect.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\RedirectController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\RedirectController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\RedirectController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\RedirectController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\RedirectController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\RedirectController::class, 'destroy'])->name('destroy');
//                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\QuestionController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\RedirectController::class, "bulk"])->name('bulk');
                    });

                Route::prefix('questions')->name('question.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\QuestionController::class, 'index'])->name('index');
//                        Route::get('create', [\App\Http\Controllers\Admin\TransportController::class, 'create'])->name('create');
//                        Route::post('store', [\App\Http\Controllers\Admin\TransportController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\QuestionController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\QuestionController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\QuestionController::class, 'destroy'])->name('destroy');
//                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\QuestionController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\QuestionController::class, "bulk"])->name('bulk');
                    });

                Route::prefix('reports')->name('report.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\ReportController::class, "index"])->name('index');
                        Route::get('/basket', [\App\Http\Controllers\Admin\ReportController::class, "basketReport"])->name('basket');
                        Route::get('/inventory', [\App\Http\Controllers\Admin\ReportController::class, "inventoryReport"])->name('inventory');
                        Route::get('/returns', [\App\Http\Controllers\Admin\ReportController::class, "returnsReport"])->name('returns');
                        Route::get('/financial', [\App\Http\Controllers\Admin\ReportController::class, "financialReport"])->name('financial');
                        Route::get('/forecast', [\App\Http\Controllers\Admin\ReportController::class, "forecastReport"])->name('forecast');

                        Route::get('/period/sales', [\App\Http\Controllers\Admin\ReportController::class, "salesReport"])->name('period-sales');
                        Route::get('/top/products', [\App\Http\Controllers\Admin\ReportController::class, "topProductsReport"])->name('top-products');
                        Route::get('/customer/behavior', [\App\Http\Controllers\Admin\ReportController::class, "customerBehaviorReport"])->name('customer-behavior');
                    });
                Route::prefix('setting')->name('setting.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\SettingController::class, "index"])->name('index');
                        Route::post('store', [\App\Http\Controllers\Admin\SettingController::class, "store"])->name('store');
                        Route::post('update', [\App\Http\Controllers\Admin\SettingController::class, "update"])->name('update');
                        Route::get('cache/clear', [\App\Http\Controllers\Admin\SettingController::class, "cacheClear"])->name('cache-clear');
                        Route::get('live/{slug?}', [\App\Http\Controllers\Admin\SettingController::class, "liveEdit"])->name('live');
                    }
                );
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
                Route::prefix('states')->name('state.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\StateController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\StateController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\StateController::class, 'store'])->name('store');
                        Route::get('show/{item}', [\App\Http\Controllers\Admin\StateController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\StateController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\StateController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\StateController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\StateController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\StateController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\StateController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('tags')->name('tag.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\TagController::class, 'index'])->name('index');
                    });
                Route::prefix('tickets')->name('ticket.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\TicketController::class, 'index'])->name('index');
//                        Route::get('create', [\App\Http\Controllers\Admin\TicketController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\TicketController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\TicketController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\TicketController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\TicketController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [\App\Http\Controllers\Admin\TicketController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('transports')->name('transport.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\TransportController::class, 'index'])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\TransportController::class, 'create'])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\TransportController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [\App\Http\Controllers\Admin\TransportController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [\App\Http\Controllers\Admin\TransportController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [\App\Http\Controllers\Admin\TransportController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [\App\Http\Controllers\Admin\TransportController::class, 'restore'])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\TransportController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [\App\Http\Controllers\Admin\TransportController::class, "trashed"])->name('trashed');
                    });
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
                        Route::get('switch/theme', [\App\Http\Controllers\Admin\UserController::class, "switchTheme"])->name('switch-theme');
                    });

            });

    });

Route::get('/theme/variable', [\App\Http\Controllers\ThemeController::class, 'cssVariables'])->name('theme.variable.css');

Route::middleware([\App\Http\Middleware\VisitorCounter::class])
    ->name('client.')->group(function () {
        // index
        Route::get('/', [ClientController::class, 'welcome'])->name('welcome');
        Route::get('/posts', [ClientController::class, 'posts'])->name('posts');
        Route::get('/post/{post?}', [ClientController::class, 'post'])->name('post');
        Route::get('/customer/sign-out', [ClientController::class, 'signOut'])->name('sign-out');
        Route::post('/customer/sign-in/do', [ClientController::class, 'singInDo'])->name('sign-in-do');
        Route::get('/customer/sign-in', [ClientController::class, 'signIn'])->name('sign-in');
        Route::get('/customer/sign-up', [ClientController::class, 'signUp'])->name('sign-up');
        Route::post('/customer/sign-up/now', [ClientController::class, 'signUpNow'])->name('sign-up-now');
        Route::get('/customer/send/auth-code', [ClientController::class, 'sendSms'])->name('send-sms');
        Route::get('/customer/check/auth-code', [ClientController::class, 'checkAuth'])->name('check-auth');
        Route::get('/customer/profile', [\App\Http\Controllers\CustomerController::class, 'profile'])->name('profile');
        Route::post('/customer/rate', [ClientController::class, 'rate'])->name('rate');
        Route::get('/compare', [ClientController::class, 'compare'])->name('compare');
        Route::get('/contact-us', [ClientController::class, 'contact'])->name('contact');
        Route::post('/contact-us/submit', [ClientController::class, 'sendContact'])->name('send-contact');
        Route::get('/galleries', [ClientController::class, 'galleries'])->name('galleries');
        Route::get('/videos', [ClientController::class, 'clips'])->name('clips');
        Route::post('/card/check', [\App\Http\Controllers\CardController::class, 'check'])->name('card.check');
        Route::post('/card/credit/check', [\App\Http\Controllers\CardController::class, 'checkCredit'])->name('card.check.credit');
        Route::get('/card/discount/{code?}', [\App\Http\Controllers\CardController::class, 'discount'])->name('card.discount');
        Route::get('/card/items', [\App\Http\Controllers\CardController::class, 'items'])->name('card.items');
        Route::get('/card', [\App\Http\Controllers\CardController::class, 'index'])->name('card');
        Route::get('/cardClear', [\App\Http\Controllers\CardController::class, 'clearing'])->name('card.clear');
        Route::get('/profile', [\App\Http\Controllers\CustomerController::class, 'profile'])->name('profile');
        Route::get('/addresses', [\App\Http\Controllers\CustomerController::class, 'addresses'])->name('addresses');
        Route::post('/address/store', [\App\Http\Controllers\CustomerController::class, 'addressStore'])->name('address.store');
        Route::post('/address/update/{address?}', [\App\Http\Controllers\CustomerController::class, 'addressUpdate'])->name('address.update');
        Route::get('/address/destroy/{address?}', [\App\Http\Controllers\CustomerController::class, 'addressDestroy'])->name('address.destroy');
        Route::post('/profile/save', [\App\Http\Controllers\CustomerController::class, 'save'])->name('profile.save');
//        Route::post('/credit/inc', [\App\Http\Controllers\CustomerController::class, 'incCredit'])->name('credit.inc');
        Route::post('/ticket/submit', [\App\Http\Controllers\CustomerController::class, 'submitTicket'])->name('ticket.submit');
        Route::post('/ticket/answer/{ticket?}', [\App\Http\Controllers\CustomerController::class, 'ticketAnswer'])->name('ticket.answer');
        Route::get('/ticket/{ticket?}', [\App\Http\Controllers\CustomerController::class, 'showTicket'])->name('ticket.show');
        Route::get('/invoice/{invoice?}', [\App\Http\Controllers\CustomerController::class, 'invoice'])->name('invoice');
        Route::get('/products', [ClientController::class, 'products'])->name('products');
        Route::get('/attachments', [ClientController::class, 'attachments'])->name('attachments');
        Route::get('/attachment/{attachment?}', [ClientController::class, 'attachment'])->name('attachment');
        Route::get('/tag/{slug?}', [ClientController::class, 'tag'])->name('tag'); // wip
        Route::get('/group/{slug?}', [ClientController::class, 'group'])->name('group'); // wip
        Route::get('/creator/{slug?}', [ClientController::class, 'creator'])->name('creator'); // wip
        Route::get('/product/{product?}', [ClientController::class, 'product'])->name('product');
        Route::get('/video/{clip?}', [ClientController::class, 'clip'])->name('clip');
        Route::get('/category/{category?}', [ClientController::class, 'category'])->name('category');
        Route::get('/gallery/{gallery?}', [ClientController::class, 'gallery'])->name('gallery');
        Route::post('/search', [ClientController::class, 'ajaxSearch'])->name('search.ajax');
        Route::get('/search', [ClientController::class, 'search'])->name('search');
        Route::get('attach/download/{attachment?}', [ClientController::class, 'attachDl'])->name('attach-dl');
        Route::get('pay/{invoice?}', [ClientController::class, 'pay'])->name('pay');

        Route::get('product/fav/toggle/{product?}', [\App\Http\Controllers\CustomerController::class, 'ProductFavToggle'])->name('product-fav-toggle');
        Route::get('product/compare/toggle/{product?}', [\App\Http\Controllers\CardController::class, 'productCompareToggle'])->name('product-compare-toggle');
        Route::get('card/toggle/{product?}', [\App\Http\Controllers\CardController::class, 'productCardToggle'])->name('product-card-toggle');

        Route::post('/comment/submit', [ClientController::class, 'submitComment'])->name('comment.submit');

        Route::prefix('credit')->name('credit.')->group(function () {
            Route::post('/charge', [\App\Http\Controllers\CreditController::class, 'chargeCredit'])->name('charge.process');
        });
    });


Route::get('/sitemap.xml', [ClientController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap/products.xml', [ClientController::class, 'sitemapProducts'])->name('sitemap.products');
Route::get('/sitemap/posts.xml', [ClientController::class, 'sitemapPosts'])->name('sitemap.posts');
Route::get('/sitemap/clips.xml', [ClientController::class, 'sitemapClips'])->name('sitemap.clips');
Route::get('/sitemap/galleries.xml', [ClientController::class, 'sitemapGalleries'])->name('sitemap.galleries');
Route::get('/sitemap/attachments.xml', [ClientController::class, 'sitemapAttachments'])->name('sitemap.attachments');
Route::get('/sitemap/categories.xml', [ClientController::class, 'sitemapGroupCategory'])->name('sitemap.categories');
Route::get('/rss/post.xml', [ClientController::class, 'postRss'])->name('rss.post');
Route::get('/rss/product.xml', [ClientController::class, 'productRss'])->name('rss.product');

// to developer test
Route::get('login/as/{mobile}', function ($mobile) {
    if (auth()->check() && auth()->user()->hasRole('developer')) {
        if ($mobile == 1) {
            return \Auth::guard('customer')
                ->loginUsingId(\App\Models\Customer::inRandomOrder()->first()->id);
        } else {
            return \Auth::guard('customer')
                ->loginUsingId(\App\Models\Customer::where('mobile', $mobile)->first()->id);
        }
    } else {
        return abort(403);
    }
})->name('login.as');

Route::get('test', function () {
    $p = \App\Models\Product::first();
    return $p->evaluations();
})->name('test');


Route::get('whoami', function () {
    if (!auth('customer')->check()) {
        return 'You are nothing';
    }
    return \Auth::guard('customer')->user();
})->name('whoami');

//Route::get('/payment/redirect/bank/{invoice}/{gateway}', \App\Http\Controllers\Payment\GatewayRedirectController::class)->name('redirect.bank');
Route::any('/payment/check/{invoice_hash}/{gateway}', \App\Http\Controllers\Payment\GatewayVerifyController::class)->name('pay.check');

Route::any('{lang}/{any}', [ClientController::class, 'lang'])
    ->where('any', '.*')
    ->where('lang', '[A-Za-z]{2}')
    ->middleware([\App\Http\Middleware\LangControl::class, \App\Http\Middleware\VisitorCounter::class]);
Route::any('{lang}', [ClientController::class, 'langIndex'])
    ->where('lang', '[A-Za-z]{2}')
    ->middleware([\App\Http\Middleware\LangControl::class, \App\Http\Middleware\VisitorCounter::class]);


Route::any('under-construction', [ClientController::class, 'underConstruction'])->name('client.under-construction');

// handle fallback redirect
Route::fallback(function (Request $request) {
    $redirectMiddleware = new \App\Http\Middleware\RedirectMiddleware();
    return $redirectMiddleware->handle($request, function() {
        return response()->view('errors.404', [], 404);
    });
});
