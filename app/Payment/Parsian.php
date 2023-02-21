<?php


namespace App\Payment;


use App\Contracts\Payment;

class Parsian implements Payment
{

    /**
     * @var \Dpsoft\Parsian\Parsian
     */
    private $gateway;

    public function __construct(\Dpsoft\Parsian\Parsian $gateway)
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
        return 'parsian';
    }

    /**
     * Get payment type must be one of: ONLINE, CHEQUE, CARD, CASH, CASH_ON_DELIVERY
     *
     * @return string
     */
    public static function getType(): string
    {
        return 'ONLINE';
    }

    public static function isActive():bool
    {
        return !empty(config('payment.payment.parsian.pin'));
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
        return $this->gateway->request($amount, $callbackUrl);

    }

    /**
     * Redirect customer to bank payment page
     */
    public function goToBank()
    {
        return redirect()->away($this->gateway->getPaymentUrl());
    }

    /**
     * Verify payment
     * @return array successful payment result like token or orderId
     * @throws \Throwable if payment fail
     */
    public function verify(): array
    {
        $response = $this->gateway->verify();
        return [
            'reference_id' => $response['RRN'],
            'card_number' => $response['hash_card_number'],
        ];
    }

    public static function registerService()
    {
        app()->singleton(
            'parsian-gateway',
            function () {
                $gateway = new \Dpsoft\Parsian\Parsian(config('payment.payment.parsian.pin'));

                return new Parsian($gateway);
            }
        );
    }

    public static function getLogo()
    {
        return asset('payment/image/parsian.png');
    }
}
