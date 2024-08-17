<?php

namespace App\Events;

use App\Models\Invoice;
use Illuminate\Queue\SerializesModels;

class InvoiceCompleted
{
    use SerializesModels;

    /**
     * @var Invoice
     */
    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
}
