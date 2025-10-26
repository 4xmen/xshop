# Payment Gateway Logos

This directory contains logo images for payment gateways.

## Required Images

- `shaparak.png` - Logo for Iranian payment gateways (Zarinpal, Zibal)
- `paypal.png` - Logo for PayPal payment gateway

## Image Specifications

- Format: PNG (recommended for transparency)
- Recommended size: 200x80 pixels or similar aspect ratio
- Background: Transparent or white

## Adding Payment Gateway Logos

1. Add your logo image to this directory
2. Reference it in your payment gateway class using:
   ```php
   public static function getLogo()
   {
       return asset('payment/image/your-logo.png');
   }
   ```
