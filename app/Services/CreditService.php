<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Credit;
use App\Models\Payment;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class CreditService
{
    public function chargeCredit(Customer $customer, int $amount, Payment $payment = null, string $description = null,Invoice $invoice = null,): Credit
    {
        return DB::transaction(function () use ($customer, $amount, $payment, $description) {
            // Update customer credit balance
            $customer->credit += $amount;
            $customer->save();

            // Create credit transaction record
            return Credit::create([
                'customer_id' => $customer->id,
                'type' => Credit::TYPE_CHARGE,
                'amount' => $amount,
                'status' => Credit::STATUS_COMPLETED,
                'payment_id' => $payment?->id,
                'description' => $description ?? __('Credit charge'),
                'data' => json_encode([
                    'message' => __('Credit charge')
                ]),
                'processed_at' => now()
            ]);
        });
    }

    public function payWithCredit(Customer $customer, int $amount, Invoice $invoice, string $description = null): Credit
    {
        if ($customer->credit < $amount) {
            throw new \Exception(__('Insufficient credit balance'));
        }

        return DB::transaction(function () use ($customer, $amount, $invoice, $description) {
            // Deduct from customer credit
            $customer->credit -= $amount;
            $customer->save();
            $invoice->status = "COMPLETED";
            $invoice->save();

            // Create credit transaction record
            return Credit::create([
                'customer_id' => $customer->id,
                'type' => Credit::TYPE_PAYMENT,
                'amount' => -$amount, // Negative for payment
                'status' => Credit::STATUS_COMPLETED,
                'invoice_id' => $invoice->id,
                'data' => json_encode([
                    'message' => __("Pay for invoice") . ' ' . $invoice->hash,
                ]),
                'description' => $description ?? __('Payment for invoice :hash', ['hash' => $invoice->hash]),
                'processed_at' => now()
            ]);
        });
    }

    public function adminAdjustment(Customer $customer, int $amount, string $description): Credit
    {
        return DB::transaction(function () use ($customer, $amount, $description) {
            // Update customer credit balance
            $customer->credit += $amount;
            $customer->save();

            // Create credit transaction record
            return Credit::create([
                'customer_id' => $customer->id,
                'type' => Credit::TYPE_ADMIN_ADJUSTMENT,
                'amount' => $amount,
                'status' => Credit::STATUS_COMPLETED,
                'description' => $description,
                'data' => json_encode([
                    'user_id' => auth()->user()->id,
                    'message' => __("Increase / decrease by Admin"),
                ]),
                'processed_at' => now()
            ]);
        });
    }
    public function refundCredit(Customer $customer, int $amount, Invoice $invoice = null, string $description = null): Credit
    {
        return DB::transaction(function () use ($customer, $amount, $invoice, $description) {
            // Add to customer credit
            $customer->credit += $amount;
            $customer->save();

            // Create credit transaction record
            return Credit::create([
                'customer_id' => $customer->id,
                'type' => Credit::TYPE_REFUND,
                'amount' => $amount,
                'status' => Credit::STATUS_COMPLETED,
                'invoice_id' => $invoice?->id,
                'description' => $description ?? __('Credit refund'),
                'data' => json_encode([
                    'message' => __('Credit refund'),
                ]),
                'processed_at' => now()
            ]);
        });
    }

    public function getCustomerCreditHistory(Customer $customer, int $limit = 20)
    {
        return Credit::where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->paginate($limit);
    }

    public function hasInsufficientCredit(Customer $customer, int $amount): bool
    {
        return $customer->credit < $amount;
    }
}
