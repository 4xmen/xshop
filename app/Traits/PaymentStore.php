<?php

namespace App\Traits;

use App\Events\InvoiceFailed;
use App\Events\InvoiceSucceed;
use App\Models\Payment;


trait PaymentStore
{
    public function storePaymentRequest($orderId,$amount, $token = null, $type = 'ONLINE', $bank = null): \App\Models\Payment
    {
        $payment = new Payment();
        $payment->order_id = $orderId;
        $payment->type = $type?$type:'ONLINE';
        $payment->amount=$amount;
        $payment->meta = [
            'fingerprint' => \Request::fingerprint(),
            'bank'        => $bank,
            'token'       => $token,
            'ip'          => \Request::ip(),
            'auth_user'   => \Auth::id(),
            'user_agent'  => \Request::userAgent(),
        ];
        /** @var \App\Models\Invoice $this */
        $this->payments()->save($payment);

//        $payment->save();

        return $payment;
    }

    public function storeSuccessPayment($paymentId, $referenceId, $cardNumber = null): \App\Models\Payment
    {
        /** @var Payment $payment */
        $payment = Payment::findOrFail($paymentId);
        $payment->reference_id = $referenceId;
        $payment->meta = array_merge($payment->meta, ['card_number' => $cardNumber]);
        $payment->status = "SUCCESS";
        $payment->save();
        /** @var \App\Models\Invoice $this */
        $this->status = "COMPLETED";
        $this->save();
        try {
            event(new InvoiceSucceed($this, $payment));
        }catch (\Throwable $exception){
            \Log::debug('Error In Event OrderSucceed. But Process Continued!',compact('payment'));
            \Log::warning($exception->getMessage(),[$exception->getTraceAsString()]);
        }

        return $payment;
    }

    public function storeFailPayment($paymentId, $message = null): \App\Models\Payment
    {
        try {
            /** @var Payment $payment */
            $payment = Payment::findOrFail($paymentId);
            if ($payment->status === Payment::SUCCESS) {
                return $payment;
            }
            $payment->status = Payment::FAIL;
            $payment->comment = $message;
            $payment->save();
        } catch (\Throwable $exception) {
            $payment = new Payment();
        }
        $this->status = "FAILED";
        /** @var \App\Models\Invoice $this */
        $this->save();
        event(new InvoiceFailed($this, $payment));

        return $payment;
    }
}
