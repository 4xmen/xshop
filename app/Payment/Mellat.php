<?php


namespace App\Payment;


use App\Contracts\Payment;

class Mellat implements Payment
{

    /**
     * @var \Dpsoft\Mellat\Mellat
     */
    private $gateway;

    public function __construct(\Dpsoft\Mellat\Mellat $gateway)
    {
        $this->gateway = $gateway;
    }

    public static function registerService()
    {
        app()->singleton(
            'mellat-gateway',
            function () {
                $gateway = new \Dpsoft\Mellat\Mellat(
                    config('payment.payment.mellat.terminal_id'),
                    config('payment.payment.mellat.user_name'),
                    config('payment.payment.mellat.password')
                );

                return new Mellat($gateway);
            }
        );
    }

    /**
     * Get Payment name
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'mellat';
    }

    public static function getType(): string
    {
        return 'ONLINE';
    }

    public static function isActive():bool
    {
        return !empty(config('payment.payment.mellat.terminal_id'));
    }

    /**
     * Request online payment
     *
     * @param  int  $amount  transaction amount
     * @param  string  $callbackUrl  a url that callback user after transaction
     * @param  array  $additionalData  additional data to send back
     * @return array request data like token and order id
     * @throws \Exception
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
        return $this->gateway->redirectScript();
    }

    /**
     * Verify payment
     * @return array successful payment result like token or orderId
     * @throws \Exception if payment fail
     */
    public function verify(): array
    {
        return $this->gateway->verify();
    }

    public static function getLogo()
    {
        return asset('payment/image/mellat.jpg');
    }
}
