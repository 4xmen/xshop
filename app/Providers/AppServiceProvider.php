<?php

namespace App\Providers;
use App\Helpers\TDate;
use App\Http\Middleware\Acl;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
