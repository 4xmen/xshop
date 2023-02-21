<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Quantity;
use function App\Helpers\sendSMSText;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function created(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "updated" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        //
        if ($invoice->wasChanged('tracking_code') && strlen($invoice->tracking_code) == 24){
            sendSMSText($invoice->customer->mobile, config('app.name').PHP_EOL.'کد رهگیری سفارش شما:'.$invoice->tracking_code);
        }
        if ($invoice->wasChanged('status') && $invoice->status == Invoice::CANCELED){
                $pros = $invoice->products()->withPivot(['quantity_id', 'count'])->get();
                foreach ($pros as $pr) {
                    $q = Quantity::whereId($pr->pivot->quantity_id)->first();
                    if ($q == null || $pr->pivot->count == null){
                        continue;
                    }
                    $q->count += $pr->pivot->count;
                    $q->save();
                    $q->product->stock_quantity += $pr->pivot->count;
                    $q->product->save();
                }
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
