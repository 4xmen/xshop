<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::prefix(config('starter-kit.uri'))->name('admin.')->group(
    function () {
        Route::group(
            ['middleware' => ['auth']],
            function () {


                Route::prefix('users')->name('user.')->group(
                    function () {
                        Route::get('/all', [\App\Http\Controllers\Admin\UserController::class,'index'])->name('all');
                        Route::get('/delete/{user}',  [\App\Http\Controllers\Admin\UserController::class,'destroy'])->name('delete');
                        Route::get('/create',  [\App\Http\Controllers\Admin\UserController::class,'create'])->name('create');
                        Route::post('/store',  [\App\Http\Controllers\Admin\UserController::class,'store'])->name('store');
                        Route::get('/edit/{user}',  [\App\Http\Controllers\Admin\UserController::class,'edit'])->name('edit');
                        Route::post('/update/{user}',  [\App\Http\Controllers\Admin\UserController::class,'update'])->name('update');
                    });

                Route::prefix('cat')->name('cat.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\CatController::class, "index"])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\CatController::class, "create"])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\CatController::class, "store"])->name('store');
                        Route::get('edit/{cat}', [\App\Http\Controllers\Admin\CatController::class, "edit"])->name('edit');
                        Route::get('show/{cat}', [\App\Http\Controllers\Admin\CatController::class, "show"])->name('show');
                        Route::post('update/{cat}', [\App\Http\Controllers\Admin\CatController::class, "update"])->name('update');
                        Route::get('delete/{cat}', [\App\Http\Controllers\Admin\CatController::class, "destroy"])->name('delete');
                        Route::get('sort', [\App\Http\Controllers\Admin\CatController::class, "sort"])->name('sort');
                        Route::post('sortStore', [\App\Http\Controllers\Admin\CatController::class, "sortStore"])->name('sortStore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\CatController::class, "bulk"])->name('bulk');
                    }
                );

                Route::prefix('product')->name('product.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\ProductController::class, "index"])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\ProductController::class, "create"])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\ProductController::class, "store"])->name('store');
                        Route::get('edit/{product}', [\App\Http\Controllers\Admin\ProductController::class, "edit"])->name('edit');
                        Route::get('show/{product}', [\App\Http\Controllers\Admin\ProductController::class, "show"])->name('show');
                        Route::post('update/{product}', [\App\Http\Controllers\Admin\ProductController::class, "update"])->name('update');
                        Route::get('delete/{product}', [\App\Http\Controllers\Admin\ProductController::class, "destroy"])->name('delete');
                        Route::get('restore/{product}', [\App\Http\Controllers\Admin\ProductController::class, "restore"])->name('restore');
                        Route::post('bulk', [\App\Http\Controllers\Admin\ProductController::class, "bulk"])->name('bulk');
                    }
                );

                Route::prefix('customer')->name('customer.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\CustomerController::class, "index"])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\CustomerController::class, "create"])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\CustomerController::class, "store"])->name('store');
                        Route::get('edit/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, "edit"])->name('edit');
                        Route::get('show/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, "show"])->name('show');
                        Route::post('update/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, "update"])->name('update');
                        Route::get('delete/{customer}', [\App\Http\Controllers\Admin\CustomerController::class, "destroy"])->name('delete');
                        Route::post('bulk', [\App\Http\Controllers\Admin\CustomerController::class, "bulk"])->name('bulk');
                    }
                );

                Route::prefix('props')->name('props.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\PropController::class, "index"])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\PropController::class, "create"])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\PropController::class, "store"])->name('store');
                        Route::get('edit/{id}', [\App\Http\Controllers\Admin\PropController::class, "edit"])->name('edit');
                        Route::post('update/{id}', [\App\Http\Controllers\Admin\PropController::class, "update"])->name('update');
                        Route::get('delete/{id}', [\App\Http\Controllers\Admin\PropController::class, "delete"])->name('delete');
                        Route::get('sort/{catid}', [\App\Http\Controllers\Admin\PropController::class, "sort"])->name('sort');
                        Route::post('sortStore', [\App\Http\Controllers\Admin\PropController::class, "sortStore"])->name('sortStore');
                    }
                );
                Route::prefix('discount')->name('discount.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\DiscountController::class, "index"])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\DiscountController::class, "create"])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\DiscountController::class, "store"])->name('store');
                        Route::get('edit/{discount}', [\App\Http\Controllers\Admin\DiscountController::class, "edit"])->name('edit');
                        Route::post('update/{discount}', [\App\Http\Controllers\Admin\DiscountController::class, "update"])->name('update');
                        Route::get('delete/{discount}', [\App\Http\Controllers\Admin\DiscountController::class, "destroy"])->name('delete');
                        Route::post('bulk', [\App\Http\Controllers\Admin\DiscountController::class, "bulk"])->name('bulk');
                    }
                );
                Route::prefix('transport')->name('transport.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\TransportController::class, "index"])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\TransportController::class, "create"])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\TransportController::class, "store"])->name('store');
                        Route::get('edit/{transport}', [\App\Http\Controllers\Admin\TransportController::class, "edit"])->name('edit');
                        Route::post('update/{transport}', [\App\Http\Controllers\Admin\TransportController::class, "update"])->name('update');
                        Route::get('delete/{transport}', [\App\Http\Controllers\Admin\TransportController::class, "destroy"])->name('delete');
                        Route::post('bulk', [\App\Http\Controllers\Admin\TransportController::class, "bulk"])->name('bulk');
                    }
                );

                Route::prefix('question')->name('question.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\QuestionController::class, "index"])->name('index');
                        Route::get('edit/{question}', [\App\Http\Controllers\Admin\QuestionController::class, "edit"])->name('edit');
                        Route::post('update/{question}', [\App\Http\Controllers\Admin\QuestionController::class, "update"])->name('update');
                        Route::get('delete/{question}', [\App\Http\Controllers\Admin\QuestionController::class, "destroy"])->name('delete');
                        Route::post('bulk', [\App\Http\Controllers\Admin\QuestionController::class, "bulk"])->name('bulk');
                    }
                );

                Route::prefix('ticket')->name('ticket.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\TicketController::class, "index"])->name('index');
                        Route::get('edit/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, "edit"])->name('edit');
                        Route::post('store', [\App\Http\Controllers\Admin\TicketController::class, "store"])->name('store');
                        Route::post('update/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, "update"])->name('update');
                        Route::get('delete/{ticket}', [\App\Http\Controllers\Admin\TicketController::class, "destroy"])->name('delete');
                        Route::post('bulk', [\App\Http\Controllers\Admin\TicketController::class, "bulk"])->name('bulk');
                    }
                );

                Route::prefix('invoice')->name('invoice.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\InvoiceController::class, "index"])->name('index');
                        Route::get('create', [\App\Http\Controllers\Admin\InvoiceController::class, "create"])->name('create');
                        Route::post('store', [\App\Http\Controllers\Admin\InvoiceController::class, "store"])->name('store');
                        Route::get('edit/{invoice}', [\App\Http\Controllers\Admin\InvoiceController::class, "edit"])->name('edit');
                        Route::get('show/{invoice}', [\App\Http\Controllers\Admin\InvoiceController::class, "show"])->name('show');
                        Route::post('update/{invoice}', [\App\Http\Controllers\Admin\InvoiceController::class, "update"])->name('update');
                        Route::get('delete/{invoice}', [\App\Http\Controllers\Admin\InvoiceController::class, "destroy"])->name('delete');
                        Route::post('bulk', [\App\Http\Controllers\Admin\InvoiceController::class, "bulk"])->name('bulk');
                    }
                );

                Route::prefix('attachment')->name('attachment.')->group(
                    function () {
                        Route::get('', [\App\Http\Controllers\Admin\AttachmentController::class, "index"])->name('index');
                        Route::post('store', [\App\Http\Controllers\Admin\AttachmentController::class, "store"])->name('store');
                        Route::get('delete/{attachment}', [\App\Http\Controllers\Admin\AttachmentController::class, "destroy"])->name('delete');
                    }
                );

                Route::prefix('setting')->name('setting.')->group(
                    function () {
                        Route::get('index', [\App\Http\Controllers\Admin\SettingController::class, "index"])->name('index');
                        Route::post('store', [\App\Http\Controllers\Admin\SettingController::class, "store"])->name('store');
                        Route::post('update', [\App\Http\Controllers\Admin\SettingController::class, "update"])->name('update');
                        Route::post('remMenu/{id}', [\App\Http\Controllers\Admin\SettingController::class, "remMenu"])->name('remMenu');
                    }
                );

            });

        Route::prefix('contact')->name('contact.')->group(
            function () {
                Route::get('index', [\App\Http\Controllers\Admin\ContactController::class, "index"])->name('index');
                Route::get('show/{con}', [\App\Http\Controllers\Admin\ContactController::class, "show"])->name('show');
                Route::get('delete/{con}', [\App\Http\Controllers\Admin\ContactController::class, "destroy"])->name('delete');
                Route::post('reply/{con}', [\App\Http\Controllers\Admin\ContactController::class, "reply"])->name('reply');
                Route::post('bulk', [\App\Http\Controllers\Admin\ContactController::class, "bulk"])->name('bulk');
            }
        );
    });
Route::get('/props/list/{id}', [\App\Http\Controllers\Admin\PropController::class, 'list'])->name('props.list');

// for under construction


Route::group(
    ['middleware' => ['under']],
    function () {

        Route::get('/', [App\Http\Controllers\WebsiteController::class, 'index'])->name('welcome');
        Route::get('/product-category/{cat}', [App\Http\Controllers\WebsiteController::class, 'cat'])->name('cat');
        Route::get('/product/{pro}', [App\Http\Controllers\WebsiteController::class, 'product'])->name('product');
        Route::get('/compare/remove/{pro}', [App\Http\Controllers\WebsiteController::class, 'compareRem'])->name('compare.rem');
        Route::get('/compare/add/{pro}', [App\Http\Controllers\WebsiteController::class, 'compareAdd'])->name('compare.add');
        Route::get('/compare', [App\Http\Controllers\WebsiteController::class, 'compare'])->name('compare');
        Route::get('/card-add/{id}', [App\Http\Controllers\WebsiteController::class, 'cardAdd'])->name('card.add');
        Route::get('/card-rem/{id}', [App\Http\Controllers\WebsiteController::class, 'cardRem'])->name('card.rem');
        Route::get('/card-add-q/{id}/{count}', [App\Http\Controllers\WebsiteController::class, 'cardAddQ'])->name('card.addq');
        Route::get('/card-rem-q/{id}', [App\Http\Controllers\WebsiteController::class, 'cardRemQ'])->name('card.remq');
        Route::get('/post/{post}', [App\Http\Controllers\WebsiteController::class, 'post'])->name('post');
        Route::get('/products', [App\Http\Controllers\WebsiteController::class, 'products'])->name('products');
        Route::get('/search/ajax', [App\Http\Controllers\WebsiteController::class, 'searchAjax'])->name('search.ajax');
        Route::get('/search', [App\Http\Controllers\WebsiteController::class, 'search'])->name('search');
        Route::get('/card', [App\Http\Controllers\WebsiteController::class, 'card'])->name('card.show');
        Route::get('/sign', [App\Http\Controllers\WebsiteController::class, 'sign'])->name('sign');
        Route::get('/customer/invoice/{invoice}', [App\Http\Controllers\CustomerController::class, 'invoice'])->name('customer.invoice')->middleware('auth:customer');
        Route::get('/customer/address/save', [App\Http\Controllers\CustomerController::class, 'saveAddress'])->name('customer.address')->middleware('auth:customer');
        Route::get('/customer/address/rem/{address}', [App\Http\Controllers\CustomerController::class, 'remAddress'])->name('customer.remaddress')->middleware('auth:customer');
        Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer')->middleware('auth:customer');
        Route::post('/signin', [\App\Http\Controllers\Auth\LoginController::class, 'customerLogin'])->name('signin');
        Route::post('/signup', [\App\Http\Controllers\Auth\RegisterController::class, 'createCustomer'])->name('signup');
        Route::post('/question/send', [\App\Http\Controllers\WebsiteController::class, 'questionSend'])->name('question.send');
        Route::post('/sendSMS', [\App\Http\Controllers\WebsiteController::class, 'sendSMS'])->name('sendSMS');
        Route::post('/checkSMS', [\App\Http\Controllers\WebsiteController::class, 'checkSMS'])->name('checkSMS');
        Route::post('/profile', [\App\Http\Controllers\WebsiteController::class, 'profile'])->name('profile');
        Route::get('/logout', [\App\Http\Controllers\WebsiteController::class, 'logout'])->name('logout');
        Route::post('/discount', [\App\Http\Controllers\WebsiteController::class, 'discount'])->name('discount');
        Route::get('/invoice/qr/{hash}', [\App\Http\Controllers\CustomerController::class, 'qr'])->name('invoice.qr');
        Route::get('/invoice/pdf/{hash}', [\App\Http\Controllers\CustomerController::class, 'pdf'])->name('invoice.pdf');
        Route::post('/ticket/send', [\App\Http\Controllers\CustomerController::class, 'SendTicket'])->name('ticket.send');
        Route::get('/ticket/{ticket}', [\App\Http\Controllers\CustomerController::class, 'ticket'])->name('ticket.show');
        Route::get('/posts', [App\Http\Controllers\WebsiteController::class, 'posts'])->name('posts');
        Route::get('/track', [App\Http\Controllers\WebsiteController::class, 'track'])->name('track');
    });

Route::get('/underConstruct', function () {
    return view('website.under');
});
Route::prefix('')->name('n.')->group(function () {
    Route::get('mag', [App\Http\Controllers\WebsiteController::class, 'mag'])->name('mag');
    Route::get('tag/{tag}', [App\Http\Controllers\WebsiteController::class, 'tag'])->name('tag');
    Route::get('category/{category}', [App\Http\Controllers\WebsiteController::class, 'category'])->name('category');
    Route::get('category/{cat}', [App\Http\Controllers\WebsiteController::class, 'cat'])->name('cat');
    Route::get('n/{post}', [App\Http\Controllers\WebsiteController::class, 'post'])->name('show');
    Route::get('galleries', [App\Http\Controllers\WebsiteController::class, 'galleries'])->name('galleries');
    Route::get('clips', [App\Http\Controllers\WebsiteController::class, 'clips'])->name('clips');
//    Route::get('faq', "WebsiteController@faq")->name('faq'); //ESH
    Route::get('g/{gallery}', [App\Http\Controllers\WebsiteController::class, 'gallery'])->name('gallery');
    Route::get('s/{term}', [App\Http\Controllers\WebsiteController::class, 'search'])->name('search');

    Route::post('comment/post/{post}', [App\Http\Controllers\WebsiteController::class, 'commentPost'])->name('comment.post');
    Route::post('comment/product/{product}', [App\Http\Controllers\WebsiteController::class, 'commentProduct'])->name('comment.product');
    Route::post('like/{news}', [App\Http\Controllers\WebsiteController::class, 'like'])->name('like');
    Route::post('vote/{poll}', [App\Http\Controllers\WebsiteController::class, 'vote'])->name('vote');
    Route::get('poll/{poll}', [App\Http\Controllers\WebsiteController::class, 'poll'])->name('poll');
    Route::get('goadv/{adv}', [App\Http\Controllers\WebsiteController::class, 'goadv'])->name('goadv');
//    Route::post('assign', [App\Http\Controllers\WebsiteController::class, ''])->name('assign');
});

// site map
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap/posts.xml', [App\Http\Controllers\SitemapController::class, 'posts'])->name('sitemap.posts');
Route::get('/sitemap/cats.xml', [App\Http\Controllers\SitemapController::class, 'cats'])->name('sitemap.cats');
Route::get('/sitemap/products.xml', [App\Http\Controllers\SitemapController::class, 'products'])->name('sitemap.products');

//Route::get('impex/customer', [App\Http\Controllers\ImpexController::class, 'customer'])->name('impex.customer');
//Route::get('impex/col', [App\Http\Controllers\ImpexController::class, 'col'])->name('impex.col');
//Route::get('impex/crwl', [App\Http\Controllers\ImpexController::class, 'crwl'])->name('impex.crwl');
//Route::get('impex/crwl2', [App\Http\Controllers\ImpexController::class, 'crwl2'])->name('impex.crwl2');
//Route::get('impex/getPro', [App\Http\Controllers\ImpexController::class, 'getPro'])->name('impex.getPro');
//Route::get('impex/getInv', [App\Http\Controllers\ImpexController::class, 'getInv'])->name('impex.getInv');
Route::get('impex/login', [App\Http\Controllers\ImpexController::class, 'login'])->name('impex.login');
Route::get('impex/login/as/{tel}', [App\Http\Controllers\ImpexController::class, 'loginas'])->name('impex.loginas');


Route::get('/home', function () {
    return redirect((config('starter-kit.uri')));
})->name('home');

Auth::routes([
    'register' => false,
]);
//
Route::post('/invoice', [\App\Http\Controllers\Payment\GatewayRedirectController::class, 'createInvoice'])->middleware('auth:customer')->name('invoice.create');
Route::get('/redirect/bank/{invoice}/{gateway}', \App\Http\Controllers\Payment\GatewayRedirectController::class)->name('redirect.bank');
Route::any('/pay/check/{invoice_hash}/{gateway}', \App\Http\Controllers\Payment\GatewayVerifyController::class)->name('pay.check');
Route::get('/fav/toggle/{product}', [App\Http\Controllers\WebsiteController::class, 'favToggle'])->name('fav.toggle');
Route::post('/contact/send', [App\Http\Controllers\WebsiteController::class, "sendContact"])->name('sendcontact');
Route::get('/contact', [App\Http\Controllers\WebsiteController::class, "contact"])->name('contact');
Route::get('/reset', [App\Http\Controllers\WebsiteController::class, "reset"])->name('reset');
Route::get('/resetStock', [App\Http\Controllers\WebsiteController::class, "resetStockStatus"])->name('resetStock');
Route::get('/resetQ', [App\Http\Controllers\WebsiteController::class, "resetQuantity"])->name('resetQuantity');
Route::get('/credit/pay/{invoice}', [App\Http\Controllers\CustomerController::class, 'credit'])->name('credit');

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
if (\App\Helpers\getSetting('redirect') == 'yes') {
    Route::get('{any}', [\App\Http\Controllers\RedirectController::class, 'check'])->where('any', '.*');
}
