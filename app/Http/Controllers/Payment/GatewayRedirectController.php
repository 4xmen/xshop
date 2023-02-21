<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\WebsiteController;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Quantity;
use App\Models\Product;
use App\Models\Transport;
use Illuminate\Http\Request;
use function Ramsey\Collection\remove;

class GatewayRedirectController
{
    public function __invoke(Invoice $invoice, $gateway)
    {
        if ($invoice->isCompleted()) {
            return redirect()->back()->with('message', __('Invoice payed.'));
        }

        $callbackUrl = route('pay.check', ['invoice_hash' => $invoice->hash, 'gateway' => $gateway->getName()]);
        $payment = null;
        try {
            $response = $gateway->request( ($invoice->total_price - $invoice->credit_price), $callbackUrl);
            $payment = $invoice->storePaymentRequest($response['order_id'], ($invoice->total_price - $invoice->credit_price), $response['token'] ?? null, null, $gateway->getName());
            session(["payment_id" => $payment->id]);
            \Session::save();

            return $gateway->goToBank();
        } catch (\Throwable $exception) {
            $invoice->status = 'FAILED';
            $invoice->save();
            \Log::error("Payment REQUEST exception: " . $exception->getMessage());
            \Log::warning($exception->getTraceAsString());
            $result = false;
            $message = __(' لطفا درگاه بانک را تعویض نمایید.');
            return view("payment.result", compact('invoice', 'payment', 'result', 'message'));
        }
    }

    public function createInvoice(Request $request)
    {

        if (\Session::has('shoping_card')){
            \Session::remove('shoping_card');
            \Session::save();
        }else{
            return redirect()->route('customer')->with(['message' => __('The order is duplicate please check invoices list')]);
        }
        $dis = Discount::where('code',\request('discount') );
        if ($dis->count() > 0){
            $invData['discount_id']=  $dis->firstOrFail()->id;
            $discountAmount = $dis->firstOrFail()->amount;
        }
        $invoice = new Invoice();
        $invoice->total_price = 0;
        $invoice->reserve = $request->has('reserve');
        $invoice->desc = $request->desc ;
        $invoice->customer_id = auth('customer')->id();
        $invoice->hash = md5(time().config('app.name'));

        if ($request->has('transport_id')){
            $invoice->transport_id = $request->transport_id ;
        }
        if ($request->has('address_id') && $request->address_id != '0'){
            $invoice->address_id = $request->address_id ;
        }else{

            $invoice->address_id = null ;
        }
        if ($request->has('invoice_id')){
            $invoice->invoice_id = $request->invoice_id ;
        }


        // add by quantity
        foreach ($request->input('qcount',[]) as $id => $buyCount) {
            $q = Quantity::whereId($id)->first();

            $product = $q->product;
            $product->sell_count += $buyCount;
            $product->stock_quantity -= $buyCount;
            $product->save();
            $proData = [
                'count' => $buyCount,
                'quantity_id' => $id,
                'price_total' => ($q->price * ($buyCount)),
                'data'=>json_encode($q),
            ];
            $invoice->total_price += $proData['price_total'];
            $invoice->save();
            $invoice->products()->save(
                $product,
                $proData
            );
            $q->count -= $buyCount;
            $q->save();

        }
        // add by product

        foreach ($request->input('products',[]) as $item) {
            $product = Product::find($item);
            $product->sell_count += \request('count')[$item];
            $product->stock_quantity -= \request('count')[$item];
            $product->save();
            $proData = [
                'count' => \request('count')[$item],
                'price_total' => ($product->price * (\request('count')[$item]))
            ];
            if (isset(\request('data')[$item])){
                $temp = json_decode(\request('data')[$item]);
                $qd = Quantity::find($temp->id);
                $qd->count -= \request('count')[$item];
                $proData['data'] = \request('data')[$item];
                $proData['price_total'] = $qd->price *  \request('count')[$item];
                $proData['quantity_id'] = $qd->id;
                $product->price = $qd->price;
                $qd->save();
            }
            $invoice->save();
            $invoice->products()->save(
                $product,
                $proData
            );
            $invoice->total_price = $invoice->total_price + ($product->price * (\request('count')[$item]));
            $invoice->save();
        }
        // alternative address
        if ($request->has('address_alt')){
            $invoice->address_alt  = $request->address_alt;
        }
        // fix problem
        if (!isset($discountAmount)){
            $discountAmount = 0;
        }
        $invoice->total_price =   $invoice->total_price - $discountAmount;
        if ($request->has('transport_id')){
            $t = Transport::whereId($request->transport_id)->first();
            $invoice->total_price +=   $t->price;
        }
//        dd($invoice);
//        $invoice->update(['total_price' =>, 'hash' => ]);
        \Session::remove('card');
        \Session::remove('qcard');
        \Session::remove('qcounts');
        \Session::save();
        WebsiteController::resetQuantity();
        if ($request->has('nopay')){
            return redirect()->route('customer')->with(['message' => __('You order reserved for a few hours, please pay to complete process')]);
        }else{
            return $this->__invoke($invoice, app(config('app.pay_gate').'-gateway'));
        }
    }

    function check($invoice,$gatway, Request $request){
        return [$invoice,$gatway,$request->all()];
    }
}
