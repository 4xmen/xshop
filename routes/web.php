<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin;
use App\Http\Controllers;


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix(config('app.panel.prefix'))->name('admin.')->group(
    function () {
        Route::group(
            ['middleware' => ['auth']],
            function () {


                Route::get('/', [Controllers\HomeController::class, 'index'])->name('home');

                Route::get('adminlogs', [Admin\AdminLogController::class, 'index'])->name('adminlog.index');
                Route::get('adminlogs/{user}', [Admin\AdminLogController::class, 'log'])->name('adminlog.show');
                Route::post('ckeditor/upload', [Admin\CkeditorController::class, 'upload'])->name('ckeditor.upload');
                Route::get('guestlog', [Admin\GuestLogController::class, 'index'])->name('guestlog.index');
                Route::post('images/store/{gallery}', [Admin\ImageController::class, 'store'])->name('image.store');
                Route::get('images/destroy/{image}', [Admin\ImageController::class, 'destroy'])->name('image.destroy');
                Route::any('logout', [Controllers\Auth\LoginController::class, 'logout'])->name('logout');
                Route::get('rates', [Admin\RateController::class, 'index'])->name('rate.index');


                Route::prefix('addresses')->name('address.')->group(
                    function () {
                        Route::get('customer/{item?}', [Admin\AddressController::class, 'customer'])->name('customer');
                        Route::post('add/{item?}', [Admin\AddressController::class, 'store'])->name('store');
                        Route::post('update/{item?}', [Admin\AddressController::class, 'update'])->name('update');
                        Route::get('destroy/{item?}', [Admin\AddressController::class, 'destroy'])->name('destroy');
                    });
                Route::prefix('adv')->name('adv.')->group(
                    function () {
                        Route::get('', [Admin\AdvController::class, 'index'])->name('index');
                        Route::get('create', [Admin\AdvController::class, 'create'])->name('create');
                        Route::post('store', [Admin\AdvController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\AdvController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\AdvController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\AdvController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\AdvController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\AdvController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\AdvController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\AdvController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('area')->name('area.')->group(
                    function () {
                        Route::get('index', [Admin\AreaController::class, "index"])->name('index');
                        Route::get('design/{area}', [Admin\AreaController::class, "design"])->name('design');
                        Route::get('design/model/{area?}/{model?}/{id?}', [Admin\AreaController::class, "designModel"])->name('design.model');
                        Route::get('image/{segment?}/{part?}', [Admin\AreaController::class, "image"])->name('image');
//                        Route::post('store', [Admin\SettingController::class, "store"])->name('store');
                        Route::post('update/{area}', [Admin\AreaController::class, "update"])->name('update');
                        Route::post('update/model/{model?}/{id?}', [Admin\AreaController::class, "updateModel"])->name('update.model');
                        Route::get('sort/{area?}', [Admin\AreaController::class, "sort"])->name('sort');
                        Route::get('build', [Admin\AreaController::class, "build"])->name('build');
                        Route::get('guide', [Admin\AreaController::class, "guide"])->name('guide');
                        Route::post('sort-save/{area?}', [Admin\AreaController::class, "sortSave"])->name('sort-save');
                    }
                );

                Route::prefix('attachments')->name('attachment.')->group(
                    function () {
                        Route::get('', [Admin\AttachmentController::class, 'index'])->name('index');
                        Route::get('create', [Admin\AttachmentController::class, 'create'])->name('create');
                        Route::post('store', [Admin\AttachmentController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\AttachmentController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\AttachmentController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\AttachmentController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\AttachmentController::class, 'destroy'])->name('destroy');
                        Route::get('premium/toggle/{item?}', [Admin\AttachmentController::class, 'togglePremium'])->name('toggle-premium');
                        Route::get('detach/{item?}', [Admin\AttachmentController::class, 'detach'])->name('detach');
                        Route::post('bulk', [Admin\AttachmentController::class, "bulk"])->name('bulk');
                        Route::post('attaching', [Admin\AttachmentController::class, "attaching"])->name('attaching');
                    });
                Route::prefix('categories')->name('category.')->group(
                    function () {
                        Route::get('', [Admin\CategoryController::class, 'index'])->name('index');
                        Route::get('create', [Admin\CategoryController::class, 'create'])->name('create');
                        Route::post('store', [Admin\CategoryController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\CategoryController::class, 'edit'])->name('edit');
                        Route::get('show/{item}', [Admin\CategoryController::class, 'show'])->name('show');
                        Route::post('update/{item}', [Admin\CategoryController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\CategoryController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\CategoryController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\CategoryController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\CategoryController::class, "trashed"])->name('trashed');
                        Route::post('sort/save', [Admin\CategoryController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [Admin\CategoryController::class, 'sort'])->name('sort');
                    });
                Route::prefix('cities')->name('city.')->group(
                    function () {
                        Route::get('', [Admin\CityController::class, 'index'])->name('index');
                        Route::get('create', [Admin\CityController::class, 'create'])->name('create');
                        Route::post('store', [Admin\CityController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\CityController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\CityController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\CityController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\CityController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\CityController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\CityController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\CityController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('clips')->name('clip.')->group(
                    function () {
                        Route::get('', [Admin\ClipController::class, 'index'])->name('index');
                        Route::get('create', [Admin\ClipController::class, 'create'])->name('create');
                        Route::post('store', [Admin\ClipController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\ClipController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\ClipController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\ClipController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\ClipController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\ClipController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\ClipController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\ClipController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('contacts')->name('contact.')->group(
                    function () {
                        Route::get('', [Admin\ContactController::class, 'index'])->name('index');
//                        Route::get('create', [Admin\TicketController::class, 'create'])->name('create');
                        Route::post('store', [Admin\ContactController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\ContactController::class, 'show'])->name('show');
                        Route::post('reply/{item}', [Admin\ContactController::class, 'reply'])->name('reply');
                        Route::get('delete/{item}', [Admin\ContactController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [Admin\ContactController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('comments')->name('comment.')->group(
                    function () {
                        Route::get('', [Admin\CommentController::class, 'index'])->name('index');
                        Route::get('status/{item}/{status}', [Admin\CommentController::class, 'status'])->name('status');
                        Route::get('delete/{item}', [Admin\CommentController::class, 'destroy'])->name('destroy');
                        Route::get('reply/{item}', [Admin\CommentController::class, 'reply'])->name('reply');
                        Route::post('replying/{item}', [Admin\CommentController::class, 'replying'])->name('replying');
                        Route::post('bulk', [Admin\CommentController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('customers')->name('customer.')->group(
                    function () {
                        Route::get('', [Admin\CustomerController::class, 'index'])->name('index');
                        Route::get('create', [Admin\CustomerController::class, 'create'])->name('create');
                        Route::post('store', [Admin\CustomerController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\CustomerController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\CustomerController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\CustomerController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\CustomerController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\CustomerController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\CustomerController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\CustomerController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('discounts')->name('discount.')->group(
                    function () {
                        Route::get('', [Admin\DiscountController::class, 'index'])->name('index');
                        Route::get('create', [Admin\DiscountController::class, 'create'])->name('create');
                        Route::post('store', [Admin\DiscountController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\DiscountController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\DiscountController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\DiscountController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\DiscountController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\DiscountController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\DiscountController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('evaluations')->name('evaluation.')->group(
                    function () {
                        Route::get('', [Admin\EvaluationController::class, 'index'])->name('index');
                        Route::get('create', [Admin\EvaluationController::class, 'create'])->name('create');
                        Route::post('store', [Admin\EvaluationController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\EvaluationController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\EvaluationController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\EvaluationController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\EvaluationController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\EvaluationController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\EvaluationController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('galleries')->name('gallery.')->group(
                    function () {
                        Route::get('', [Admin\GalleryController::class, 'index'])->name('index');
                        Route::get('create', [Admin\GalleryController::class, 'create'])->name('create');
                        Route::post('store', [Admin\GalleryController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\GalleryController::class, 'show'])->name('show');
                        Route::post('title/update', [Admin\GalleryController::class, 'updateTitle'])->name('title');
                        Route::get('edit/{item}', [Admin\GalleryController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\GalleryController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\GalleryController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [Admin\GalleryController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('gfx')->name('gfx.')->group(
                    function () {
                        Route::get('index', [Admin\GfxController::class, "index"])->name('index');
//                        Route::post('store', [Admin\SettingController::class, "store"])->name('store');
                        Route::post('update', [Admin\GfxController::class, "update"])->name('update');
                    }
                );
                Route::prefix('groups')->name('group.')->group(
                    function () {
                        Route::get('', [Admin\GroupController::class, 'index'])->name('index');
                        Route::get('create', [Admin\GroupController::class, 'create'])->name('create');
                        Route::post('store', [Admin\GroupController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\GroupController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\GroupController::class, 'update'])->name('update');
                        Route::get('show/{item}', [Admin\GroupController::class, 'show'])->name('show');
                        Route::get('delete/{item}', [Admin\GroupController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\GroupController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\GroupController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\GroupController::class, "trashed"])->name('trashed');
                        Route::post('sort/save', [Admin\GroupController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [Admin\GroupController::class, 'sort'])->name('sort');
                    });
                Route::prefix('creator')->name('creator.')->group(
                    function () {
                        Route::get('', [Admin\CreatorController::class, 'index'])->name('index');
                        Route::get('create', [Admin\CreatorController::class, 'create'])->name('create');
                        Route::post('store', [Admin\CreatorController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\CreatorController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\CreatorController::class, 'update'])->name('update');
                        Route::get('show/{item}', [Admin\CreatorController::class, 'show'])->name('show');
                        Route::get('delete/{item}', [Admin\CreatorController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\CreatorController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\CreatorController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\CreatorController::class, "trashed"])->name('trashed');
                        Route::post('sort/save', [Admin\CreatorController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [Admin\CreatorController::class, 'sort'])->name('sort');
                    });
                Route::prefix('invoices')->name('invoice.')->group(
                    function () {
                        Route::get('', [Admin\InvoiceController::class, 'index'])->name('index');
//                        Route::get('create', [Admin\InvoiceController::class, 'create'])->name('create');
//                        Route::post('store', [Admin\InvoiceController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\InvoiceController::class, 'edit'])->name('edit');
                        Route::get('show/{item}', [Admin\InvoiceController::class, 'show'])->name('show');
                        Route::post('update/{item}', [Admin\InvoiceController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\InvoiceController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\InvoiceController::class, 'restore'])->name('restore');
                        Route::get('remove/ordere/{order}', [Admin\InvoiceController::class, 'removeOrder'])->name('remove-order');
                        Route::post('bulk', [Admin\InvoiceController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\InvoiceController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('langs')->name('lang.')->group(
                    function () {
                        Route::get('/', [Admin\XLangController::class, 'index'])->name('index');
                        Route::get('/translates', [Admin\XLangController::class, 'translate'])->name('translate');
                        Route::get('/delete/{item}', [Admin\XLangController::class, 'destroy'])->name('delete');
                        Route::get('/create', [Admin\XLangController::class, 'create'])->name('create');
                        Route::post('/store', [Admin\XLangController::class, 'store'])->name('store');
                        Route::get('/edit/{item}', [Admin\XLangController::class, 'edit'])->name('edit');
                        Route::post('/update/{item}', [Admin\XLangController::class, 'update'])->name('update');
                        Route::post('bulk', [Admin\XLangController::class, "bulk"])->name('bulk');
                        Route::get('/download/{tag}', [Admin\XLangController::class, 'download'])->name('download');
                        Route::get('/ai/{tag}', [Admin\XLangController::class, 'ai'])->name('ai');
                        Route::get('/online/edit/{tag}', [Admin\XLangController::class, 'onlineEdit'])->name('onlineEdit');
                        Route::post('/save/edit/{tag}', [Admin\XLangController::class, 'editSave'])->name('editSave');
                        Route::post('/batch', [Admin\XLangController::class, 'batch'])->name('batch');
                        Route::post('/upload/{tag}', [Admin\XLangController::class, 'upload'])->name('upload');
                        Route::get('/model/translate/{id}/{model}', [Admin\XLangController::class, 'translateModel'])->name('model');
                        Route::post('/model/translate/save/{id}/{model}', [Admin\XLangController::class, 'translateModelSave'])->name('modelSave');
                        Route::get('/model/ai/{id}/{model}/{field}/{lang}', [Admin\XLangController::class, 'translateModelAi'])->name('aiText');
                        Route::get('restore/{item}', [Admin\XLangController::class, 'restore'])->name('restore');
                        Route::get('trashed', [Admin\XLangController::class, "trashed"])->name('trashed');

                    });
                Route::prefix('menus')->name('menu.')->group(
                    function () {
                        Route::get('', [Admin\MenuController::class, 'index'])->name('index');
                        Route::get('create', [Admin\MenuController::class, 'create'])->name('create');
                        Route::post('store', [Admin\MenuController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\MenuController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\MenuController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\MenuController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\MenuController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\MenuController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\MenuController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\MenuController::class, "trashed"])->name('trashed');
                        Route::post('sort/save', [Admin\MenuController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort/{item}', [Admin\MenuController::class, 'sort'])->name('sort');
                    });
                Route::prefix('posts')->name('post.')->group(
                    function () {
                        Route::get('', [Admin\PostController::class, 'index'])->name('index');
                        Route::get('create', [Admin\PostController::class, 'create'])->name('create');
                        Route::post('store', [Admin\PostController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\PostController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\PostController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\PostController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\PostController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\PostController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\PostController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\PostController::class, "trashed"])->name('trashed');
                        Route::get('group/edit/{id?}', [Admin\PostController::class, 'groupEdit'])->name('group-edit');
                        Route::post('group/save/{item?}', [Admin\PostController::class, 'groupSave'])->name('group-save');
                    });
                Route::prefix('pages')->name('page.')->group(
                    function () {
                        Route::get('', [Admin\PageController::class, 'index'])->name('index');
                        Route::get('create', [Admin\PageController::class, 'create'])->name('create');
                        Route::post('store', [Admin\PageController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\PageController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\PageController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\PageController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\PageController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\PageController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\PageController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\PageController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('products')->name('product.')->group(
                    function () {
                        Route::get('', [Admin\ProductController::class, 'index'])->name('index');
                        Route::get('create', [Admin\ProductController::class, 'create'])->name('create');
                        Route::post('store', [Admin\ProductController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\ProductController::class, 'show'])->name('show');
                        Route::post('title/update', [Admin\ProductController::class, 'updateTitle'])->name('title');
                        Route::get('edit/{item?}', [Admin\ProductController::class, 'edit'])->name('edit');
                        Route::post('update/{item?}', [Admin\ProductController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\ProductController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\ProductController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\ProductController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\ProductController::class, "trashed"])->name('trashed');
                        Route::get('category/edit/{id?}', [Admin\ProductController::class, 'categoryEdit'])->name('category-edit');
                        Route::post('category/save/{item?}', [Admin\ProductController::class, 'categorySave'])->name('category-save');

                    });
                Route::prefix('props')->name('prop.')->group(
                    function () {
                        Route::get('', [Admin\PropController::class, 'index'])->name('index');
                        Route::get('create', [Admin\PropController::class, 'create'])->name('create');
                        Route::post('store', [Admin\PropController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\PropController::class, 'show'])->name('show');
                        Route::post('title/update', [Admin\PropController::class, 'updateTitle'])->name('title');
                        Route::get('edit/{item}', [Admin\PropController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\PropController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\PropController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\PropController::class, 'restore'])->name('restore');

                        Route::post('bulk', [Admin\PropController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\PropController::class, "trashed"])->name('trashed');

                        Route::post('sort/save', [Admin\PropController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [Admin\PropController::class, 'sort'])->name('sort');
                    });


                Route::prefix('redirects')->name('redirect.')->group(
                    function () {
                        Route::get('', [Admin\RedirectController::class, 'index'])->name('index');
                        Route::get('create', [Admin\RedirectController::class, 'create'])->name('create');
                        Route::post('store', [Admin\RedirectController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\RedirectController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\RedirectController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\RedirectController::class, 'destroy'])->name('destroy');
//                        Route::get('restore/{item}', [Admin\QuestionController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\RedirectController::class, "bulk"])->name('bulk');
                    });

                Route::prefix('questions')->name('question.')->group(
                    function () {
                        Route::get('', [Admin\QuestionController::class, 'index'])->name('index');
//                        Route::get('create', [Admin\TransportController::class, 'create'])->name('create');
//                        Route::post('store', [Admin\TransportController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\QuestionController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\QuestionController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\QuestionController::class, 'destroy'])->name('destroy');
//                        Route::get('restore/{item}', [Admin\QuestionController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\QuestionController::class, "bulk"])->name('bulk');
                    });

                Route::prefix('reports')->name('report.')->group(
                    function () {
                        Route::get('', [Admin\ReportController::class, "index"])->name('index');
                        Route::get('/basket', [Admin\ReportController::class, "basketReport"])->name('basket');
                        Route::get('/inventory', [Admin\ReportController::class, "inventoryReport"])->name('inventory');
                        Route::get('/returns', [Admin\ReportController::class, "returnsReport"])->name('returns');
                        Route::get('/financial', [Admin\ReportController::class, "financialReport"])->name('financial');
                        Route::get('/forecast', [Admin\ReportController::class, "forecastReport"])->name('forecast');

                        Route::get('/period/sales', [Admin\ReportController::class, "salesReport"])->name('period-sales');
                        Route::get('/top/products', [Admin\ReportController::class, "topProductsReport"])->name('top-products');
                        Route::get('/customer/behavior', [Admin\ReportController::class, "customerBehaviorReport"])->name('customer-behavior');
                    });
                Route::prefix('setting')->name('setting.')->group(
                    function () {
                        Route::get('index', [Admin\SettingController::class, "index"])->name('index');
                        Route::post('store', [Admin\SettingController::class, "store"])->name('store');
                        Route::post('update', [Admin\SettingController::class, "update"])->name('update');
                        Route::get('cache/clear', [Admin\SettingController::class, "cacheClear"])->name('cache-clear');
                        Route::get('live/{slug?}', [Admin\SettingController::class, "liveEdit"])->name('live');
                    }
                );
                Route::prefix('sliders')->name('slider.')->group(
                    function () {
                        Route::get('', [Admin\SliderController::class, 'index'])->name('index');
                        Route::get('create', [Admin\SliderController::class, 'create'])->name('create');
                        Route::post('store', [Admin\SliderController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\SliderController::class, 'show'])->name('show');
                        Route::post('title/update', [Admin\SliderController::class, 'updateTitle'])->name('title');
                        Route::get('edit/{item}', [Admin\SliderController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\SliderController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\SliderController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [Admin\SliderController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('states')->name('state.')->group(
                    function () {
                        Route::get('', [Admin\StateController::class, 'index'])->name('index');
                        Route::get('create', [Admin\StateController::class, 'create'])->name('create');
                        Route::post('store', [Admin\StateController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\StateController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\StateController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\StateController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\StateController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\StateController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\StateController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\StateController::class, "trashed"])->name('trashed');
                    });

                Route::prefix('stories')->name('story.')->group(
                    function () {
                        Route::get('', [Admin\StoryController::class, 'index'])->name('index');
                        Route::get('create', [Admin\StoryController::class, 'create'])->name('create');
                        Route::post('store', [Admin\StoryController::class, 'store'])->name('store');
                        Route::get('show/{item}', [Admin\StoryController::class, 'show'])->name('show');
                        Route::get('edit/{item}', [Admin\StoryController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\StoryController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\StoryController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\StoryController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\StoryController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\StoryController::class, "trashed"])->name('trashed');


                        Route::post('sort/save', [Admin\StoryController::class, 'sortSave'])->name('sort-save');
                        Route::get('sort', [Admin\StoryController::class, 'sort'])->name('sort');
                    });
                Route::prefix('tags')->name('tag.')->group(
                    function () {
                        Route::get('', [Admin\TagController::class, 'index'])->name('index');
                    });
                Route::prefix('tickets')->name('ticket.')->group(
                    function () {
                        Route::get('', [Admin\TicketController::class, 'index'])->name('index');
//                        Route::get('create', [Admin\TicketController::class, 'create'])->name('create');
                        Route::post('store', [Admin\TicketController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\TicketController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\TicketController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\TicketController::class, 'destroy'])->name('destroy');
                        Route::post('bulk', [Admin\TicketController::class, "bulk"])->name('bulk');
                    });
                Route::prefix('transports')->name('transport.')->group(
                    function () {
                        Route::get('', [Admin\TransportController::class, 'index'])->name('index');
                        Route::get('create', [Admin\TransportController::class, 'create'])->name('create');
                        Route::post('store', [Admin\TransportController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\TransportController::class, 'edit'])->name('edit');
                        Route::post('update/{item}', [Admin\TransportController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\TransportController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\TransportController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\TransportController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\TransportController::class, "trashed"])->name('trashed');
                    });
                Route::prefix('users')->name('user.')->group(
                    function () {
                        Route::get('', [Admin\UserController::class, 'index'])->name('index');
                        Route::get('create', [Admin\UserController::class, 'create'])->name('create');
                        Route::post('store', [Admin\UserController::class, 'store'])->name('store');
                        Route::get('edit/{item}', [Admin\UserController::class, 'edit'])->name('edit');
                        Route::get('log/{item}', [Admin\AdminLogController::class, 'log'])->name('log');
                        Route::get('show/{item}', [Admin\UserController::class, 'show'])->name('show');
                        Route::post('update/{item}', [Admin\UserController::class, 'update'])->name('update');
                        Route::get('delete/{item}', [Admin\UserController::class, 'destroy'])->name('destroy');
                        Route::get('restore/{item}', [Admin\UserController::class, 'restore'])->name('restore');
                        Route::post('bulk', [Admin\UserController::class, "bulk"])->name('bulk');
                        Route::get('trashed', [Admin\UserController::class, "trashed"])->name('trashed');
                        Route::get('switch/theme', [Admin\UserController::class, "switchTheme"])->name('switch-theme');
                    });

            });

    });

Route::get('/theme/variable', [\App\Http\Controllers\ThemeController::class, 'cssVariables'])->name('theme.variable.css');

if (config('app.xlang.active')) {
    Route::any('/' . config('app.xlang.main') . '/{path?}', function ($path = null) {
        $url = '/' . ltrim($path ?? '', '/');

        if (request()->getQueryString()) {
            $url .= '?' . request()->getQueryString();
        }
        return redirect()->to($url, 301);
    })->where('path', '.*');
}

Route::get('/sitemap.xml', [ClientController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap/products.xml', [ClientController::class, 'sitemapProducts'])->name('sitemap.products');
Route::get('/sitemap/posts.xml', [ClientController::class, 'sitemapPosts'])->name('sitemap.posts');
Route::get('/sitemap/clips.xml', [ClientController::class, 'sitemapClips'])->name('sitemap.clips');
Route::get('/sitemap/galleries.xml', [ClientController::class, 'sitemapGalleries'])->name('sitemap.galleries');
Route::get('/sitemap/attachments.xml', [ClientController::class, 'sitemapAttachments'])->name('sitemap.attachments');
Route::get('/sitemap/categories.xml', [ClientController::class, 'sitemapGroupCategory'])->name('sitemap.categories');
Route::get('/rss/post.xml', [ClientController::class, 'postRss'])->name('rss.post');
Route::get('/rss/product.xml', [ClientController::class, 'productRss'])->name('rss.product');

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
        Route::get('/customer/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::post('/customer/rate', [ClientController::class, 'rate'])->name('rate');
        Route::get('/compare', [ClientController::class, 'compare'])->name('compare');
        Route::get('/contact-us', [ClientController::class, 'contact'])->name('contact');
        Route::post('/contact-us/submit', [ClientController::class, 'sendContact'])->name('send-contact');
        Route::get('/galleries', [ClientController::class, 'galleries'])->name('galleries');
        Route::get('/videos', [ClientController::class, 'clips'])->name('clips');
        Route::post('/card/check', [CardController::class, 'check'])->name('card.check');
        Route::post('/card/credit/check', [CardController::class, 'checkCredit'])->name('card.check.credit');
        Route::get('/card/discount/{code?}', [CardController::class, 'discount'])->name('card.discount');
        Route::get('/card/items', [CardController::class, 'items'])->name('card.items');
        Route::get('/card', [CardController::class, 'index'])->name('card');
        Route::get('/cardClear', [CardController::class, 'clearing'])->name('card.clear');
        Route::get('/addresses', [CustomerController::class, 'addresses'])->name('addresses');
        Route::post('/address/store', [CustomerController::class, 'addressStore'])->name('address.store');
        Route::post('/address/update/{address?}', [CustomerController::class, 'addressUpdate'])->name('address.update');
        Route::get('/address/destroy/{address?}', [CustomerController::class, 'addressDestroy'])->name('address.destroy');
        Route::post('/profile/save', [CustomerController::class, 'save'])->name('profile.save');
//        Route::post('/credit/inc', [CustomerController::class, 'incCredit'])->name('credit.inc');
        Route::post('/ticket/submit', [CustomerController::class, 'submitTicket'])->name('ticket.submit');
        Route::post('/ticket/answer/{ticket?}', [CustomerController::class, 'ticketAnswer'])->name('ticket.answer');
        Route::get('/ticket/{ticket?}', [CustomerController::class, 'showTicket'])->name('ticket.show');
        Route::get('/invoice/{invoice?}', [CustomerController::class, 'invoice'])->name('invoice');
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
        Route::post('story/like', [ClientController::class, 'likeStory'])->name('story.like');

        Route::get('product/fav/toggle/{product?}', [CustomerController::class, 'ProductFavToggle'])->name('product-fav-toggle');
        Route::get('product/compare/toggle/{product?}', [CardController::class, 'productCompareToggle'])->name('product-compare-toggle');
        Route::get('card/toggle/{product?}', [CardController::class, 'productCardToggle'])->name('product-card-toggle');

        Route::post('/comment/submit', [ClientController::class, 'submitComment'])->name('comment.submit');

        Route::prefix('credit')->name('credit.')->group(function () {
            Route::post('/charge', [\App\Http\Controllers\CreditController::class, 'chargeCredit'])->name('charge.process');
        });
        Route::get('/{page?}', [ClientController::class, 'page'])->name('page');
    });



// to developer test
Route::get('login/as/{mobile}', function ($mobile) {
    if (app()->environment('production')) {
        abort(403, "Unauthorized action for production mode.");
    }
    if (auth()->check() && auth()->user()->hasRole('developer') ) {
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

    return auth('customer')->user()->purchased_products();
    return null;

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

//// handle fallback redirect
//Route::fallback(function (Request $request) {
//    $redirectMiddleware = new \App\Http\Middleware\RedirectMiddleware();
//    return $redirectMiddleware->handle($request, function() {
//        return abort(404,__("Page not found"));
//    });
//});
