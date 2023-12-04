<?php

namespace App\Providers;

use App\Http\Middleware\Acl;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Xmen\StarterKit\Helpers\TDate;
use  Translator\Framework\TranslatorCommand;
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
        $this->commands([
            TranslatorCommand::class,
        ]);
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
