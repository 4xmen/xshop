# Payment Gateway Setup Guide

xShop supports multiple payment gateways for online transactions. This guide will help you configure them.

## Available Payment Gateways

### 1. Zarinpal (Iranian Gateway)
- **Type:** Online Payment
- **Region:** Iran
- **Documentation:** [docs/15-invoice.md](15-invoice.md)

### 2. Zibal (Iranian Gateway)
- **Type:** Online Payment
- **Region:** Iran
- **Documentation:** [docs/15-invoice.md](15-invoice.md)

### 3. PayPal (International Gateway)
- **Type:** Online Payment
- **Region:** International
- **Documentation:** [docs/32-paypal-payment.md](32-paypal-payment.md)

## Quick Setup

### PayPal Configuration

1. **Get Credentials:**
   - Visit [PayPal Developer Dashboard](https://developer.paypal.com/dashboard/)
   - Create an app and copy Client ID and Secret

2. **Update `.env`:**
   ```env
   PAYPAL_CLIENT_ID=your_client_id_here
   PAYPAL_SECRET=your_secret_here
   PAYPAL_MODE=sandbox  # Change to 'live' for production
   PAYPAL_CURRENCY=USD
   ```

3. **Set as Active Gateway:**
   ```env
   PAY_GATEWAY=paypal
   ```

### Zarinpal Configuration

1. **Update `.env`:**
   ```env
   ZARINPAL_MERCHANT=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
   PAY_GATEWAY=zarinpal
   ```

### Zibal Configuration

1. **Update `.env`:**
   ```env
   ZIBAL_MERCHANT=your_merchant_id
   PAY_GATEWAY=zibal
   ```

## Switching Payment Gateways

Change the active gateway in your `.env` file:

```env
PAY_GATEWAY=paypal    # Options: paypal, zarinpal, zibal
```

Or programmatically in `config/xshop.php`:

```php
'active_gateway' => env('PAY_GATEWAY', 'paypal'),
```

## Testing

### PayPal Sandbox Testing

1. Set `PAYPAL_MODE=sandbox` in `.env`
2. Create test accounts in PayPal Developer Dashboard
3. Use test account credentials during checkout
4. No real money is charged in sandbox mode

### Production

1. Update credentials to production/live credentials
2. Set `PAYPAL_MODE=live` for PayPal
3. Test with small real transactions first
4. Monitor your payment gateway dashboard

## Adding Payment Gateway Logos

Add logo images to `public/payment/image/`:
- `paypal.png` - PayPal logo
- `shaparak.png` - Iranian gateways logo

Recommended size: 200x80 pixels (PNG format)

## Troubleshooting

### Gateway Not Showing

- Verify credentials are set in `.env`
- Check `isActive()` method returns true
- Clear config cache: `php artisan config:clear`

### Payment Fails

- Check credentials are correct
- Verify mode (sandbox/live) matches credentials
- Review Laravel logs in `storage/logs/`
- Check payment gateway dashboard for errors

## Creating Custom Payment Gateway

See the existing implementations in `app/Payment/` as examples:
1. Create a new class implementing `App\Contracts\Payment`
2. Add configuration to `config/xshop.php`
3. Register the gateway in the gateways array
4. Add environment variables to `.env.example`

## Support

For detailed documentation on each gateway, see:
- [Invoice & Payment System](15-invoice.md)
- [PayPal Integration](33-paypal-payment.md)