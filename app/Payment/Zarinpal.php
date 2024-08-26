<?php

namespace App\Payment;

use App\Contracts\Payment;

class Zarinpal implements Payment
{
    public $token;
    /**
     * @var \Pishran\Zarinpal\RequestResponse
     */
    public $result;
    /**
     * @var \Pishran\Zarinpal\Zarinpal
     */
    private $gateway;

    public function __construct(\Pishran\Zarinpal\Zarinpal $gateway)
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
        return 'zarinpal';
    }

    public static function getType(): string
    {
        return 'ONLINE';
    }

    /**
     * Request online payment
     *
     * @param int $amount transaction amount
     * @param string $callbackUrl return user after transaction to this url
     * @param array $additionalData additional data to send back
     *
     * @return array request data like token,order_id
     * @throws \Exception
     */
    public function request(int $amount, string $callbackUrl, array $additionalData = []): array
    {
        $result = $this->gateway->amount($amount )->request()->callbackUrl($callbackUrl)->description(config('app.name'))->send();

        throw_unless($result->success(), \Exception::class, $result->error()->message());

        \Session::put('zarinpal_amount', $amount);
        \Session::put('zarinpal_token', $result->authority());
        \Session::save();

        $this->token = $result->authority();
        $this->result = $result;
        return [
            'order_id' => $result->authority(),
            'token' => null
        ];
    }

    /**
     * Redirect customer to bank payment page
     */
    public function goToBank()
    {
        return redirect()->away($this->result->url());
    }

    /**
     * Verify payment
     * @return array successful payment result.The array contain 2 keys: card_number, reference_id. The reference_id is reference number in banking network
     * @throws \Throwable if payment fail
     */
    public function verify(): array
    {
        $result = $this->gateway->amount(session('zarinpal_amount'))
            ->verification()
            ->authority(session('zarinpal_token'))
            ->send();
        throw_if(
            !$result->success(),
            \Exception::class,
            $result->error()->message()
        );
        return [
            'reference_id' => $result->referenceId(),
            'card_number' => $result->cardPan(),
        ];
    }


    public static function registerService()
    {
        app()->singleton(
            sprintf('%s-gateway', self::getName()),
            function () {
                $gateway = zarinpal()
                    ->merchantId(config('xshop.payment.config.zarinpal.merchant'));
                return new Zarinpal($gateway);
            }
        );
    }

    public static function isActive(): bool
    {
        return !empty(config('xshop.payment.config.zarinpal.merchant'));
    }

    public static function getLogo()
    {
        return asset('payment/image/shaparak.png');
    }

}
