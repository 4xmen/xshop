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
        'credit' => [
            'active' => true,
            'min_charge_amount' => 10000, // Minimum amount to charge
            'max_charge_amount' => 50000000, // Maximum amount to charge
        ],
    ]
];
