<?php

namespace App\Payment;

use App\Contracts\Payment as PaymentInterface;
use App\Models\Credit;
use Illuminate\Support\Facades\Auth;

class CreditPayment implements PaymentInterface
{
    private $amount;
    private $customer;
    private $additionalData = [];

    public static function registerService()
    {
        app()->singleton(
            sprintf('%s-gateway', self::getName()),
            function () {
                return new CreditPayment();
            }
        );
    }

    public static function getName(): string
    {
        return 'credit';
    }

    public static function getType(): string
    {
        return 'CREDIT';
    }

    public static function isActive(): bool
    {
        return config('xshop.payment.credit.active', true);
    }

    public static function getLogo()
    {
        return asset('assets/images/credit-logo.svg');
    }

    public function request(int $amount, string $callbackUrl, array $additionalData = []): array
    {
        $this->amount = $amount;
        $this->additionalData = $additionalData;

        // Get authenticated customer
        $this->customer = Auth::guard('customer')->user();

        if (!$this->customer) {
            throw new \Exception(__('Customer not authenticated'));
        }

        // Check if customer has sufficient credit
        if ($this->customer->credit < $amount) {
            throw new \Exception(__('Insufficient credit balance'));
        }

        // Generate order ID
        $orderId = 'CREDIT_' . time() . '_' . $this->customer->id;

        return [
            'order_id' => $orderId,
            'token' => null,
            'amount' => $amount,
            'gateway' => 'credit'
        ];
    }

    public function goToBank()
    {
        // Credit payments don't require redirection
        return redirect()->route('payment.verify.credit');
    }

    public function verify(): array
    {
        // Process credit payment
        $this->processPayment();

        return [
            'reference_id' => 'CREDIT_' . time(),
            'card_number' => null
        ];
    }

    private function processPayment()
    {
        if (!$this->customer || $this->customer->credit < $this->amount) {
            throw new \Exception(__('Payment verification failed'));
        }

        // Deduct credit from customer
        $this->customer->credit -= $this->amount;
        $this->customer->save();

        // Create credit transaction record
        Credit::create([
            'customer_id' => $this->customer->id,
            'type' => Credit::TYPE_PAYMENT,
            'amount' => -$this->amount, // Negative for payment
            'status' => Credit::STATUS_COMPLETED,
            'description' => __('Payment using credit balance'),
            'data' => $this->additionalData,
            'processed_at' => now()
        ]);
    }
}
