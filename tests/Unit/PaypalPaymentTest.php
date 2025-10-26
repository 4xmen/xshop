<?php

namespace Tests\Unit;

use App\Payment\Paypal;
use Tests\TestCase;

class PaypalPaymentTest extends TestCase
{
    /**
     * Test PayPal gateway name
     */
    public function test_paypal_gateway_name(): void
    {
        $this->assertEquals('paypal', Paypal::getName());
    }

    /**
     * Test PayPal gateway type
     */
    public function test_paypal_gateway_type(): void
    {
        $this->assertEquals('ONLINE', Paypal::getType());
    }

    /**
     * Test PayPal is active with credentials
     */
    public function test_paypal_is_active_with_credentials(): void
    {
        config([
            'xshop.payment.config.paypal.client_id' => 'test_client_id',
            'xshop.payment.config.paypal.secret' => 'test_secret'
        ]);

        $this->assertTrue(Paypal::isActive());
    }

    /**
     * Test PayPal is not active without credentials
     */
    public function test_paypal_is_not_active_without_credentials(): void
    {
        config([
            'xshop.payment.config.paypal.client_id' => '',
            'xshop.payment.config.paypal.secret' => ''
        ]);

        $this->assertFalse(Paypal::isActive());
    }

    /**
     * Test PayPal logo returns correct path
     */
    public function test_paypal_logo_path(): void
    {
        $logo = Paypal::getLogo();
        $this->assertStringContainsString('payment/image/paypal.png', $logo);
    }

    /**
     * Test PayPal service can be registered
     */
    public function test_paypal_service_registration(): void
    {
        Paypal::registerService();
        
        $this->assertTrue(app()->bound('paypal-gateway'));
        $this->assertInstanceOf(Paypal::class, app('paypal-gateway'));
    }
}
