<?php

return [
    'gateways' => [
        \App\Payment\Mellat::class,
        \App\Payment\Parsian::class,
        \App\Payment\Saderat::class,
        \App\Payment\Payir::class,
        \App\Payment\Zibal::class,
        \App\Payment\Zarinpal::class,
    ],
    'payment' => [
        // saderat bank info see: https://www.sepehrpay.com/ig/
        'saderat' => [
            'terminal_id' => env('SADERAT_TERMINAL_ID'),
        ],
        'parsian' => [
            'pin' => env('PARSIAN_PIN_ID'),
        ],
        'mellat' => [
            'terminal_id' => env('MELLAT_TERMINAL_ID'),
            'user_name' => env('MELLAT_USER_NAME'),
            'password' => env('MELLAT_PASSWORD'),
        ],
        'payir' => [
            'api_key' => env('PAYIR_API_KEY'),
        ],
        'zibal' => [
            'merchant' => env('ZIBAL_MERCHANT','zibal'),
        ],
        'zarinpal' => [
            'merchant' => env('ZARINPAL_MERCHANT'),
            'test' => env('ZARINPAL_TEST')
        ],
    ],
];
