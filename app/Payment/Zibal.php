<?php

namespace App\Payment;

use App\Contracts\Payment;

class Zibal implements Payment
{

    /**
     * @var \Dpsoft\Zibal\Zibal
     */
    private $gateway;

    public function __construct(\Dpsoft\Zibal\Zibal $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Get Payment name
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'zibal';
    }

    public static function getType(): string
    {
        return 'ONLINE';
    }

    /**
     * Request online payment
     *
     * @param int $amount transaction amount
     * @param string $callbackUrl a url that callback user after transaction
     * @param array $additionalData additional data to send back
     * @return array request data like token,order_id
     * @throws \Exception
     */
    public function request(int $amount, string $callbackUrl, array $additionalData = []): array
    {
        $result = $this->gateway->request($callbackUrl, $amount);
        \Session::put('zibal_amount', $amount);
        \Session::put('zibal_invoice_id', $result['invoice_id']);
        \Session::put('zibal_token', $result['token']);
        return [
            'order_id' => $result['invoice_id'],
            'token' => $result['token']
        ];
    }

    /**
     * Redirect customer to bank payment page
     */
    public function goToBank()
    {
        return redirect()->away($this->gateway->redirectUrl());
    }

    /**
     * Verify payment
     * @return array successful payment result.The array contain 3 key: card_number, invoice_id & reference_id. The reference_id is reference number in banking network
     * @throws \Exception if payment fail
     */
    public function verify(): array
    {
        $result = $this->gateway->verify(session('zibal_amount'), session('zibal_token'));
        return [
            'reference_id' => $result['transaction_id'],
            'card_number' => $result['card_number'],
        ];
    }


    public static function registerService()
    {
        app()->singleton(
            sprintf('%s-gateway',self::getName()),
            function () {
                $gateway = new \Dpsoft\Zibal\Zibal(config('xshop.payment.config.zibal.merchant'));

                return new Zibal($gateway);
            }
        );
    }

    public static function isActive():bool
    {
        return !empty(config('xshop.payment.config.zibal.merchant'));
    }

    public static function getLogo()
    {
        return asset('payment/image/shaparak.png');
    }

}
