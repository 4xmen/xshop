<?php

namespace App\Http\Controllers\Payment;

use App\Contracts\Payment;
use App\Http\Controllers\CardController;
use App\Models\Invoice;

class GatewayVerifyController
{
    /**
     * @param Invoice $invoice
     * @param Payment $gateway
     */
    public function __invoke($invoice_hash, $gateway)
    {
        try {
            $invoice = Invoice::whereHash($invoice_hash)->firstOrFail();
            $payment = null;
            $message = null;
            $result = true;
            $paymentId = self::getPayment($invoice);
            $response = $gateway->verify();
            $payment = $invoice->storeSuccessPayment($paymentId, $response['reference_id'], $response['card_number']);
            session(['card'=>serialize([])]);
        } catch (\Throwable $exception) {
            $result = false;
            $invoice->storeFailPayment($paymentId, $exception->getMessage());
            $message = $exception->getMessage();
            \Log::debug("Payment RESPONSE Fail For Gateway {$gateway->getName()} :" . $exception->getMessage() . " On Line {$exception->getLine()} Of File {$exception->getFile()}", ['request' => request()->all(), 'session' => request()->session()->all(), 'user' => request()->user(), 'payment_id' => $paymentId]);
            \Log::warning($exception->getTraceAsString());
            return redirect()->route('client.card')->withErrors(__("error in payment.").$message);
        }

        CardController::clear();
        return redirect()->route('client.profile')->with('message' , __("payment success"));

    }

    /**
     * @param Invoice $invoice
     * @return integer
     */
    public static function getPayment($invoice)
    {
        $paymentId = session('payment_id');
        if (empty($paymentId)) {
            $paymentId = $invoice->payments->last()->id;
        }
        return $paymentId;
    }
}
