<?php

namespace App\Providers;

use App\Http\Middleware\Acl;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Xmen\StarterKit\Helpers\TDate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        /** @var Router $router */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', Acl::class);

        Paginator::useBootstrap();
        Carbon::macro('jdate', function ($format, $tr_num = 'fa') {
            $dt = TDate::GetInstance();
            return $dt->PDate($format, self::this()->timestamp);
        });
    }
}
