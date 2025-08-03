<?php

namespace App\Http\Controllers;

use App\Contracts\Payment;
use App\Http\Controllers\Controller;
use App\Services\CreditService;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreditController extends Controller
{
    protected $creditService;

    public function __construct(CreditService $creditService)
    {
        $this->creditService = $creditService;
    }

    public function chargeCredit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => [
                'required',
                'integer',
                'min:' . config('xshop.payment.credit.min_charge_amount', 10000),
                'max:' . config('xshop.payment.credit.max_charge_amount', 50000000)
            ]
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $customer = Auth::guard('customer')->user();
        $amount = $request->input('amount');
        try {
            // Create invoice for credit charge
            $invoice = new Invoice();
            $invoice->customer_id = $customer->id;
            $invoice->total_price = $amount;
            $invoice->status = 'PENDING';
            $invoice->desc = __('Credit charge for :amount', ['amount' => number_format($amount)]);
            $invoice->meta = [
                'type' => 'credit_charge',
                'credit_amount' => $amount
            ];
            $invoice->save();

            $activeGateway = config('xshop.payment.active_gateway');
            /** @var Payment $gateway */
            $gateway = app($activeGateway . '-gateway');
            logger()->info('pay controller', ["active_gateway" => $activeGateway, "invoice" => $invoice->toArray(),]);
            $callbackUrl = route('pay.check', ['invoice_hash' => $invoice->hash, 'gateway' => $gateway->getName()]);
            $payment = null;
            try {
                $response = $gateway->request(($invoice->total_price * config('app.currency.factor')), $callbackUrl);
                $payment = $invoice->storePaymentRequest($response['order_id'], ($invoice->total_price * config('app.currency.factor')), $response['token'] ?? null, null, $gateway->getName());
                session(["payment_id" => $payment->id]);
                \Session::save();

                return $gateway->goToBank();
            } catch (\Throwable $exception) {
                $invoice->status = 'FAILED';
                $invoice->save();
                \Log::error("Payment REQUEST exception: " . $exception->getMessage());
                \Log::warning($exception->getTraceAsString());
                $result = false;
                $message = __('error in payment. contact admin.');
                return redirect()->back()->withErrors($message);
            }


        } catch (\Exception $e) {
            \Log::error('Credit charge creation failed: ' . $e->getMessage());
            return back()->with('error', __('Failed to create credit charge. Please try again.'));
        }
    }
}
