<?php

namespace App\Payment;

use App\Contracts\Payment;
use \Dpsoft\Saderat\Saderat as SaderatGateway;

class Saderat implements Payment
{

    /**
     * @var SaderatGateway
     */
    private $gateway;

    public function __construct(SaderatGateway $gateway)
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
        return 'saderat';
    }

    public static function getType(): string
    {
        return 'ONLINE';
    }

    /**
     * Request online payment
     *
     * @param  int  $amount  transaction amount
     * @param  string  $callbackUrl  a url that callback user after transaction
     * @param  array  $additionalData  additional data to send back
     * @return array request data like token and order id
     * @throws \Throwable
     */
    public function request(int $amount, string $callbackUrl, array $additionalData = []): array
    {
        $orderId = $this->gateway->request($callbackUrl, $amount);

        return ['order_id' => $orderId];
    }

    /**
     * Redirect customer to bank payment page
     */
    public function goToBank()
    {
        return $this->gateway->getRedirectScript();
    }

    /**
     * Verify payment
     * @return array successful payment result like token or orderId
     * @throws \Throwable if payment fail
     */
    public function verify(): array
    {
        $verifyData = $this->gateway->verify();

        return [
            'reference_id' => $verifyData->getDigitalReceipt(),
            'card_number' => $verifyData->getCardNumber(),
        ];
    }

    public static function registerService()
    {
        app()->singleton(
            'saderat-gateway',
            function () {
                $gateway = new \Dpsoft\Saderat\Saderat(config('payment.payment.saderat.terminal_id'));

                return new Saderat($gateway);
            }
        );
    }

    public static function isActive():bool
    {
        return !empty(config('payment.payment.saderat.terminal_id'));
    }

    public static function getLogo()
    {
        return asset('payment/image/saderat.jpg');
    }

}
