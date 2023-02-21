<?php

namespace App\Events;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Queue\SerializesModels;

class InvoiceFailed
{
    use SerializesModels;

    /**
     * @var Invoice
     */
    public $invoice;
    /**
     * @var Payment
     */
    public $payment;

    public function __construct(Invoice $invoice,Payment $payment)
    {
        $this->invoice = $invoice;
        $this->payment = $payment;
    }
}
