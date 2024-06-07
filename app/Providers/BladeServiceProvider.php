<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Blade::directive('paginated', function ($expression) {

            return "<?php

                \$items = $expression;
                \$total = \$items->total();
                \$currentPage = \$items->currentPage();
                \$perPage = \$items->perPage();
                \$from = (\$currentPage - 1) * \$perPage + 1;
                \$to = min(\$currentPage * \$perPage, \$total);

            echo \"( \$from - \$to ) \"; ?>";
        });
    }
}
