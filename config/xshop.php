<?php
return [
    "payment" => [
        'active_gateway' => env('PAY_GATEWAY', \App\Payment\Zarinpal::getName()),
        'gateways' => [
            \App\Payment\Zibal::class,
            \App\Payment\Zarinpal::class,
        ],
        'config' => [
            'zibal' => [
                'merchant' => env('ZIBAL_MERCHANT', 'zibal'),
            ],
            'zarinpal' => [
                'merchant' => env('ZARINPAL_MERCHANT'),
                'test' => env('ZARINPAL_TEST')
            ],
        ],
    ]
];
