<?php

namespace App\Listeners;

use App\Events\InvoiceSucceed;
use App\Services\CreditService;

class InvoiceSucceedListener
{
    private CreditService $creditService;

    public function __construct(CreditService $creditService)
    {
        $this->creditService = $creditService;
    }

    public function handle(InvoiceSucceed $event): void
    {
        //if the invoice is a credit increase, we need to update the customer's credit balance
        if ($event->invoice->isCriditIncrease()) {
            $this->creditService->chargeCredit($event->invoice->customer, $event->invoice->total_price, $event->payment, null, $event->invoice);
        }
    }
}
