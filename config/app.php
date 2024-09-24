<?php
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'xShop'),
    'version' => env('APP_VERSION', '2.0.0'),
    'demo' => env('APP_DEMO', false),
    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),
    'deployed' => (bool) env('APP_DEPLOYED', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Panel
    |--------------------------------------------------------------------------
    | These configuration options of the control panel
     */

    'panel' => [
        'prefix' => env('PANEL_PREFIX','dashboard'),
        'page_count' => env('PANEL_PAGE_COUNT',30),
    ],

    /*
    |--------------------------------------------------------------------------
    | currency
    |--------------------------------------------------------------------------
    | default currency data
     */

    'currency' => [
        'symbol' => env('CURRENCY_SYMBOL','$'),
        'factor' => env('CURRENCY_FACTOR',1),
        'code'=> env('CURRENCY_CODE','USD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | sign in/up config
    |--------------------------------------------------------------------------
    |
     */

    'sms' => [
        'sign' => env('SMS_SING',false),
        'driver' => env('SMS_DRIVER','direct'),
        'username' => env('SMS_USERNAME',''),
        'password' => env('SMS_PASSWORD',''),
        'number' => env('SMS_NUMBER',''),
        'url' => env('SMS_URL',''),
        'token' => env('SMS_TOKEN',''),
    ],
    /*
    |--------------------------------------------------------------------------
    | Media
    |--------------------------------------------------------------------------
    | These configuration options of medias
     */

    'media' => [
        'gallery_thumb' => env('MEDIA_GALLEY_THUMB','500x500'),
        'post_thumb' => env('MEDIA_POST_THUMB','500x500'),
        'product_thumb' => env('MEDIA_PRODUCT_THUMB','500x500'),
        'product_image' => env('MEDIA_PRODUCT_IMAGE','1200x1200'),
        'watermark_size' => env('MEDIA_WATERMARK_SIZE',15),
        'watermark_opacity' => env('MEDIA_WATERMARK_OPACITY',50),
    ],
    'xlang' => [
        'active' => (bool) env('XLANG_ACTIVE',false),
        'main' => env('XLANG_MAIN','en'),
        'api_url' => env('XLANG_API_URL',''),
    ],
    'xshop' =>[
      'payment' => [
          'gateway' =>  env('PAY_GATEWAY',''),
          'merchant_id' => env('MERCHANT_ID',''),
      ]
    ],



    /*
   |--------------------------------------------------------------------------
   | Class Aliases
   |--------------------------------------------------------------------------
   |
   | This array of class aliases will be registered when this application
   | is started. However, feel free to register as many as you wish as
   | the aliases are "lazy" loaded so they don't hinder performance.
   |
   */

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
    ])->toArray(),


    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
        Translator\Framework\TranslatorServiceProvider::class,
        \App\Providers\BladeServiceProvider::class,

    ])->toArray(),
];
