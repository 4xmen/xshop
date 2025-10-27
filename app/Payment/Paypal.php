<?php

namespace App\Payment;

use App\Contracts\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Paypal implements Payment
{
    private $clientId;
    private $secret;
    private $mode;
    private $apiUrl;
    private $orderData;

    public function __construct()
    {
        $this->clientId = config('xshop.payment.config.paypal.client_id');
        $this->secret = config('xshop.payment.config.paypal.secret');
        $this->mode = config('xshop.payment.config.paypal.mode', 'sandbox');
        
        // Set API URL based on mode
        $this->apiUrl = $this->mode === 'live' 
            ? 'https://api-m.paypal.com' 
            : 'https://api-m.sandbox.paypal.com';
    }

    /**
     * Get Payment name
     *
     * @return string
     */
    public static function getName(): string
    {
        return 'paypal';
    }

    public static function getType(): string
    {
        return 'ONLINE';
    }

    /**
     * Get PayPal access token
     *
     * @return string
     * @throws \Exception
     */
    private function getAccessToken(): string
    {
        $response = Http::withBasicAuth($this->clientId, $this->secret)
            ->asForm()
            ->post("{$this->apiUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials'
            ]);

        if (!$response->successful()) {
            throw new \Exception('Failed to get PayPal access token: ' . $response->body());
        }

        return $response->json('access_token');
    }

    /**
     * Request online payment
     *
     * @param int $amount transaction amount (in your base currency)
     * @param string $callbackUrl return user after transaction to this url
     * @param array $additionalData additional data to send back
     *
     * @return array request data like token,order_id
     * @throws \Exception
     */
    public function request(int $amount, string $callbackUrl, array $additionalData = []): array
    {
        try {
            $accessToken = $this->getAccessToken();
            
            // Convert amount to USD or your preferred currency
            // Note: PayPal requires decimal format (e.g., 10.00)
            $amountInCurrency = number_format($amount / 100, 2, '.', '');
            $currency = config('xshop.payment.config.paypal.currency', 'USD');

            $response = Http::withToken($accessToken)
                ->post("{$this->apiUrl}/v2/checkout/orders", [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [
                        [
                            'amount' => [
                                'currency_code' => $currency,
                                'value' => $amountInCurrency
                            ],
                            'description' => config('app.name') . ' Order Payment'
                        ]
                    ],
                    'application_context' => [
                        'return_url' => $callbackUrl,
                        'cancel_url' => $callbackUrl . '?cancelled=1',
                        'brand_name' => config('app.name'),
                        'landing_page' => 'NO_PREFERENCE',
                        'user_action' => 'PAY_NOW'
                    ]
                ]);

            if (!$response->successful()) {
                throw new \Exception('PayPal order creation failed: ' . $response->body());
            }

            $orderData = $response->json();
            $orderId = $orderData['id'];
            
            // Get approval URL
            $approvalUrl = collect($orderData['links'])
                ->firstWhere('rel', 'approve')['href'] ?? null;

            if (!$approvalUrl) {
                throw new \Exception('PayPal approval URL not found');
            }

            // Store order data in session
            Session::put('paypal_order_id', $orderId);
            Session::put('paypal_amount', $amount);
            Session::put('paypal_approval_url', $approvalUrl);
            Session::save();

            $this->orderData = $orderData;

            return [
                'order_id' => $orderId,
                'token' => $orderId
            ];
        } catch (\Exception $e) {
            throw new \Exception('PayPal payment request failed: ' . $e->getMessage());
        }
    }

    /**
     * Redirect customer to PayPal payment page
     */
    public function goToBank()
    {
        $approvalUrl = Session::get('paypal_approval_url');
        
        if (!$approvalUrl) {
            throw new \Exception('PayPal approval URL not found in session');
        }

        return redirect()->away($approvalUrl);
    }

    /**
     * Verify payment
     * @return array successful payment result. The array contain 2 keys: card_number, reference_id
     * @throws \Exception if payment fail
     */
    public function verify(): array
    {
        try {
            $orderId = Session::get('paypal_order_id');
            
            if (!$orderId) {
                throw new \Exception('PayPal order ID not found in session');
            }

            // Check if payment was cancelled
            if (request()->has('cancelled')) {
                throw new \Exception('Payment was cancelled by user');
            }

            $accessToken = $this->getAccessToken();

            // Capture the payment - PayPal requires empty JSON object {}
            $response = Http::withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Prefer' => 'return=representation',
                ])
                ->withBody('{}', 'application/json')
                ->post("{$this->apiUrl}/v2/checkout/orders/{$orderId}/capture");

            if (!$response->successful()) {
                Log::error('PayPal capture failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'order_id' => $orderId
                ]);
                throw new \Exception('PayPal payment capture failed: ' . $response->body());
            }

            $captureData = $response->json();

            // Check if payment was completed
            if ($captureData['status'] !== 'COMPLETED') {
                throw new \Exception('PayPal payment not completed. Status: ' . $captureData['status']);
            }

            // Get payer information
            $payerId = $captureData['payer']['payer_id'] ?? 'N/A';
            $payerEmail = $captureData['payer']['email_address'] ?? 'N/A';
            
            // Get capture ID (reference number)
            $captureId = $captureData['purchase_units'][0]['payments']['captures'][0]['id'] ?? $orderId;

            return [
                'reference_id' => $captureId,
                'card_number' => $payerEmail, // PayPal doesn't provide card number, using email instead
            ];
        } catch (\Exception $e) {
            throw new \Exception('PayPal verification failed: ' . $e->getMessage());
        }
    }

    /**
     * Register Payment Service Provider
     */
    public static function registerService()
    {
        app()->singleton(
            sprintf('%s-gateway', self::getName()),
            function () {
                return new Paypal();
            }
        );
    }

    /**
     * Check if PayPal is active
     */
    public static function isActive(): bool
    {
        return !empty(config('xshop.payment.config.paypal.client_id')) 
            && !empty(config('xshop.payment.config.paypal.secret'));
    }

    /**
     * Get PayPal logo
     */
    public static function getLogo()
    {
        return asset('payment/image/paypal.png');
    }
}
