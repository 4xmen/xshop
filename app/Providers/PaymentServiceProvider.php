<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach (config('payment.gateways') as $gateway){
            /** @var \App\Contracts\Payment $gateway */
            $gateway::registerService();
        }

        \Route::bind('gateway', function ($gatewayName) {
            return app("$gatewayName-gateway");
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
