<?php

namespace App\Http\Controllers;

use App\Contracts\Payment;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\Transport;
use Illuminate\Http\Request;

class CardController extends Controller
{

    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if (\Session::has('locate')) {
                app()->setLocale(\Session::get('locate'));
            }
            return $next($request);
        });
    }

    public function productCardToggle(Product $product)
    {

        $quantity = \request()->input('quantity', null);
        if (\Cookie::has('card')) {
            $cards = json_decode(\Cookie::get('card'), true);
            $qs = json_decode(\Cookie::get('q'), true);
            if (in_array($product->id, $cards)) {
                $found = false;
                foreach ($cards as $i => $card) {
                    if ($card == $product->id && $qs[$i] == $quantity) {
                        $found = true;
                        break;
                    }
                }
                if ($found) {
                    $msg = "Product removed from card";
                    unset($cards[$i]);
                    unset($qs[$i]);
                } else {
                    $cards[] = $product->id;
                    $qs[] = $quantity;
                    $msg = "Product added to card";
                }
            } else {
                $cards[] = $product->id;
                $qs[] = $quantity;
                $msg = "Product added to card";
            }
            $count = count($cards);
            \Cookie::queue('card', json_encode($cards), 2000);
            \Cookie::queue('q', json_encode($qs), 2000);
        } else {
            $count = 1;
            $msg = "Product added to card";
            \Cookie::queue('card', "[$product->id]", 2000);
            \Cookie::queue('q', "[null]", 2000);
            $qs = [$quantity];
            $cards = [$product->id];
        }

        if ($count > 0 && auth('customer')->check()) {
            $customer = auth('customer')->user();
            $customer->card = json_encode(['cards' => $cards, 'quantities' => $qs]);
            $customer->save();
        }

        if (\request()->ajax()) {
            return success(['count' => $count], $msg);
        } else {
            return redirect()->back()->with(['message' => $msg]);
        }
    }

    public function index()
    {
        auth('customer')->login(Customer::first());
        $area = 'card';
        $title = __("Shopping card");
        $subtitle = '';
        return view('client.default-list', compact('area', 'title', 'subtitle'));
    }

    public function check(Request $request)
    {

        $request->validate([
            'product_id' => ['required', 'array'],
            'count' => ['required', 'array'],
            'address_id' => ['required', 'exists:addresses,id'],
            'desc' => ['nullable', 'string']
        ]);
        $total = 0;
//        return $request->all();
        $invoice = new Invoice();
        $invoice->customer_id = auth('customer')->user()->id;
        $invoice->count = array_sum($request->count);
        $invoice->address_id = $request->address_id;
        $invoice->desc = $request->desc;

        if ($request->has('transport_id')) {
            $request->transport_id = $request->input('transport_id');
            $t = Transport::find($request->input('transport_id'));
            $invoice->transport_price = $t->price;
            $total += $t->price;
        }
        if ($request->has('discount_id')) {
            $request->discount_id = $request->input('discount_id');
        }

        $invoice->save();

        foreach ($request->product_id as $i => $product) {
            $order = new Order();
            $order->product_id = $product;
            $order->invoice_id = $invoice->id;
            $order->count = $request->count[$i];
            if ($request->quantity_id[$i] != '') {
                $order->quantity_id = $request->quantity_id[$i];
                $q = Quantity::find($request->quantity_id[$i]);
                $order->price_total = $q->price * $request->count[$i];
                $order->data = $q->data;

            } else {
                $p = Product::find($request->product_id[$i]);
                $order->price_total = $p->price * $request->count[$i];
            }
            $total += $order->price_total;
            $order->save();
        }

        $invoice->total_price = $total;
        $invoice->save();
        // clear shopping card
        // self::clear();
        //prepare to redirect to bank gateway
        $activeGateway = config('xshop.payment.active_gateway');
        /** @var Payment $gateway */
        $gateway = app($activeGateway . '-gateway');
        logger()->info('pay controller', ["active_gateway" => $activeGateway, "invoice" => $invoice->toArray(),]);

        if ($invoice->isCompleted()) {
            return redirect()->back()->with('message', __('Invoice payed.'));
        }

        $callbackUrl = route('pay.check', ['invoice_hash' => $invoice->hash, 'gateway' => $gateway->getName()]);
        $payment = null;
        try {
            $response = $gateway->request((($invoice->total_price - $invoice->credit_price) * config('app.currency.factor')), $callbackUrl);
            $payment = $invoice->storePaymentRequest($response['order_id'], (($invoice->total_price - $invoice->credit_price) * config('app.currency.factor')), $response['token'] ?? null, null, $gateway->getName());
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

    }


    public static function clear()
    {
        if (auth('customer')->check()) {
            $customer = auth('customer')->user();
            $customer->card = null;
            $customer->save();
        }
        \Cookie::expire('card');
        \Cookie::expire('q');
        return true;
    }

    public function clearing()
    {
        self::clear();
        return __("Card cleared");
    }

    public function discount($code)
    {
        $discount = Discount::where('code', trim($code))->where(function ($query) {
            $query->where('expire', '>=', date('Y-m-d'))
                ->orWhereNull('expire');
        })->first();
        if ($discount == null) {
            return [
                'OK' => false,
                'err' => __("Discount code isn't valid."),
            ];
        } else {
            if ($discount->type == 'PERCENT') {
                $human = $discount->title . '( ' . $discount->amount . '%' . ' )';
            } else {
                $human = '- ' . $discount->title . '( ' . $discount->amount . config('app.currency.symbol') . ' )';
            }
            return [
                'OK' => true,
                'msg' => __("Discount code is valid."),
                'data' => $discount,
                'human' => $human,
            ];
        }
    }


    public function productCompareToggle($slug)
    {

        $product = Product::where('slug', $slug)->firstOrFail();
        if (\Cookie::has('compares')) {
            $compares = json_decode(\Cookie::get('compares'), true);
            if (in_array($product->id, $compares)) {
                $msg = __("Product removed from compare");
                unset($compares[array_search($product->id, $compares)]);
            } else {
                $compares[] = $product->id;
                $msg = __("Product added to compare");
            }
            \Cookie::queue('compares', json_encode($compares), 2000);
        } else {
            $msg = "Product added to compare";
            \Cookie::queue('compares', "[$product->id]", 2000);
        }

        if (\request()->ajax()) {
            return success(null, $msg);
        } else {
            return redirect()->back()->with(['message' => $msg]);
        }
    }
}
