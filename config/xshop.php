<?php
return [
    "payment" => [
        'active_gateway' => env('PAY_GATEWAY', \App\Payment\Zarinpal::getName()),
        'gateways' => [
            \App\Payment\Zibal::class,
            \App\Payment\Zarinpal::class,
            \App\Payment\Paypal::class,
        ],
        'config' => [
            'zibal' => [
                'merchant' => env('ZIBAL_MERCHANT', 'zibal'),
            ],
            'zarinpal' => [
                'merchant' => env('ZARINPAL_MERCHANT'),
                'test' => env('ZARINPAL_TEST')
            ],
            'paypal' => [
                'client_id' => env('PAYPAL_CLIENT_ID'),
                'secret' => env('PAYPAL_SECRET'),
                'mode' => env('PAYPAL_MODE', 'sandbox'), // 'sandbox' or 'live'
                'currency' => env('PAYPAL_CURRENCY', 'USD'),
            ],
        ],
        'credit' => [
            'active' => true,
            'min_charge_amount' => 10000, // Minimum amount to charge
            'max_charge_amount' => 50000000, // Maximum amount to charge
        ],
    ]
];
