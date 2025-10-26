# PayPal Payment Gateway Integration

This document describes how to configure and use the PayPal payment gateway in xShop.

## Overview

The PayPal payment gateway allows customers to pay for their orders using PayPal accounts or credit/debit cards through PayPal's secure checkout.

## Features

- Full PayPal REST API v2 integration
- Sandbox and Live mode support
- Multiple currency support
- Secure payment processing
- Automatic payment verification
- Order tracking with PayPal reference IDs

## Installation

The PayPal gateway is already included in the xShop payment system. No additional packages are required as it uses Laravel's HTTP client.

## Configuration

### 1. Get PayPal API Credentials

1. Go to [PayPal Developer Dashboard](https://developer.paypal.com/dashboard/)
2. Log in with your PayPal account
3. Navigate to "My Apps & Credentials"
4. Create a new app or use an existing one
5. Copy your **Client ID** and **Secret**

### 2. Configure Environment Variables

Add the following to your `.env` file:

```env
# PayPal Configuration
PAYPAL_CLIENT_ID=your_paypal_client_id_here
PAYPAL_SECRET=your_paypal_secret_here
PAYPAL_MODE=sandbox  # Use 'sandbox' for testing, 'live' for production
PAYPAL_CURRENCY=USD  # Your preferred currency code

# Set PayPal as active gateway (optional)
PAY_GATEWAY=paypal
```

### 3. Currency Configuration

PayPal supports multiple currencies. Common options:
- `USD` - US Dollar
- `EUR` - Euro
- `GBP` - British Pound
- `CAD` - Canadian Dollar
- `AUD` - Australian Dollar
- And many more...

**Important:** The amount conversion in the gateway assumes your base amount is in cents/smallest unit. Adjust the conversion factor in `Paypal.php` if needed:

```php
// Current: amount / 100 (for cents to dollars)
$amountInCurrency = number_format($amount / 100, 2, '.', '');
```

## Usage

### Activating PayPal Gateway

1. Set PayPal credentials in `.env` file
2. The gateway will automatically activate when credentials are present
3. Set as active gateway in config or `.env`:
   ```env
   PAY_GATEWAY=paypal
   ```

### Payment Flow

1. **Request**: Customer initiates checkout
   - System creates PayPal order
   - Customer is redirected to PayPal
   
2. **Payment**: Customer completes payment on PayPal
   - Login to PayPal or pay as guest
   - Confirm payment details
   
3. **Return**: Customer is redirected back to your site
   - System captures the payment
   - Order is verified and completed

### Testing

For testing in sandbox mode:

1. Use sandbox credentials from PayPal Developer Dashboard
2. Create test accounts (buyer and seller) in the dashboard
3. Use test account credentials during checkout
4. No real money is charged in sandbox mode

### Going Live

When ready for production:

1. Get live credentials from PayPal Developer Dashboard
2. Update `.env` file:
   ```env
   PAYPAL_MODE=live
   PAYPAL_CLIENT_ID=your_live_client_id
   PAYPAL_SECRET=your_live_secret
   ```
3. Test thoroughly with small real transactions
4. Monitor PayPal dashboard for transactions

## Customization

### Logo

Add your PayPal logo to:
```
public/payment/image/paypal.png
```

Recommended specifications:
- Format: PNG with transparency
- Size: 200x80 pixels or similar aspect ratio

### Currency Conversion

If your system uses a different base unit, modify the conversion in `app/Payment/Paypal.php`:

```php
// Example: If amount is already in dollars
$amountInCurrency = number_format($amount, 2, '.', '');

// Example: If using a different factor
$amountInCurrency = number_format($amount / 1000, 2, '.', '');
```

### Branding

Customize the PayPal checkout experience by modifying the `application_context` in the `request()` method:

```php
'application_context' => [
    'brand_name' => 'Your Store Name',
    'landing_page' => 'LOGIN', // or 'BILLING', 'NO_PREFERENCE'
    'user_action' => 'PAY_NOW', // or 'CONTINUE'
]
```

## Troubleshooting

### Common Issues

**"Failed to get PayPal access token"**
- Check your Client ID and Secret
- Verify you're using the correct mode (sandbox/live)
- Ensure credentials match the mode

**"PayPal order creation failed"**
- Check amount is greater than 0
- Verify currency code is valid
- Check PayPal API status

**"PayPal payment not completed"**
- Customer may have cancelled payment
- Check PayPal dashboard for order status
- Review error logs for details

### Debugging

Enable Laravel logging to see detailed PayPal responses:

```php
\Log::info('PayPal Response', $response->json());
```

### Support

- [PayPal REST API Documentation](https://developer.paypal.com/docs/api/overview/)
- [PayPal Integration Guide](https://developer.paypal.com/docs/checkout/)
- [PayPal Developer Support](https://developer.paypal.com/support/)

## Security Considerations

1. **Never commit credentials** to version control
2. **Use environment variables** for sensitive data
3. **Validate amounts** server-side before creating orders
4. **Verify payments** on callback to prevent fraud
5. **Use HTTPS** in production
6. **Keep secrets secure** - don't expose in client-side code

## API Reference

### Methods

#### `request(int $amount, string $callbackUrl, array $additionalData = [])`
Creates a PayPal order and returns order details.

**Parameters:**
- `$amount` - Amount in smallest currency unit (e.g., cents)
- `$callbackUrl` - URL to return customer after payment
- `$additionalData` - Additional data (optional)

**Returns:** Array with `order_id` and `token`

#### `goToBank()`
Redirects customer to PayPal checkout page.

#### `verify()`
Captures and verifies the payment.

**Returns:** Array with `reference_id` and `card_number` (email)

**Throws:** Exception if payment fails or is cancelled

### Static Methods

- `getName()` - Returns 'paypal'
- `getType()` - Returns 'ONLINE'
- `isActive()` - Checks if credentials are configured
- `getLogo()` - Returns logo asset path
- `registerService()` - Registers PayPal service in container

## License

This PayPal integration is part of the xShop project and follows the same license.
