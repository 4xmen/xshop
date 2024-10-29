<?php

namespace App\Providers;
use App\Console\Commands\AssetsBuild;
use App\Helpers\TDate;
use App\Http\Middleware\Acl;
use App\Models\Area;
use App\Models\Part;
use App\Observers\PartObsever;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Translator\Framework\TranslatorCommand;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->commands([
            TranslatorCommand::class,
            AssetsBuild::class,
        ]);
        foreach (config('xshop.payment.gateways') as $gateway){
            /** @var \App\Contracts\Payment $gateway */
            $gateway::registerService();
        }

        \Route::bind('gateway', function ($gatewayName) {
            return app("$gatewayName-gateway");
        });
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
        Carbon::macro('ldate', function ($format) {
            if (self::this()->timestamp == 0){
                return null;
            }
            if (config('app.locale') == 'fa'){
                $format = str_replace('-','/',$format);
                return self::this()->jdate($format);
            }else{
                return date($format,self::this()->timestamp);
            }
        });

        Part::observe(PartObsever::class);


    }
}
