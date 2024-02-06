<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressSaveRequest;
use App\Http\Requests\TicketSaveRequest;
use App\Models\Address;
use App\Models\Credit;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Ticket;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\Settings\SettingsContainerAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PHPUnit\Util\Color;
use PDF;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (!\Auth::guard('customer')->check()) {
            return redirect()->route('sign');
        }
        $customer = Customer::whereId(\Auth::guard('customer')->id())->firstOrFail();
        return view('website.customer', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function invoiceLang($lang, Invoice $invoice)
    {
        return $this->invoice($invoice);
    }

    public function invoice(Invoice $invoice)
    {
        $options = new QROptions([
            'version' => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_L,
//            'imageTransparent' => true,
        ]);
        $qr = new QRCode($options);
        return view('website.invoice', compact('invoice', 'qr'));
    }


    public function qrLang($lang, $hash)
    {
        return $this->qr($hash);
    }

    public function qr($hash)
    {
        $invoice = Invoice::where('hash', $hash)->firstOrFail();
        $options = new QROptions([
            'version' => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_L,
//            'imageTransparent' => true,
        ]);
        $qr = new QRCode($options);
        return view('website.qr', compact('invoice', 'qr'));
    }

    public function pdfLang($lang, $hash)
    {
        return $this->pdf($hash);
    }

    public function pdf($hash)
    {
        $invoice = Invoice::where('hash', $hash)->firstOrFail();
        $options = new QROptions([
            'version' => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_L,
//            'imageTransparent' => true,
        ]);
        $qr = new QRCode($options);

        $data = [
            'invoice' => $invoice,
            'qr' => $qr,
        ];
        $pdf = PDF::loadView('website.pdf', $data);
        return $pdf->stream('website.pdf');

//        $p =   view('website.pdf',compact('invoice','qr'))->render();
    }

    public function SendTicket(TicketSaveRequest $request)
    {
        $t = new Ticket();
        if ($request->has('title')) {
            $t->title = $request->title;
        } else {
            if (Ticket::whereId($request->parent_id)->firstOrFail()->customer_id != auth('customer')->id()) {
                return abort(403);
            } else {
                $t->parent_id = $request->parent_id;
            }
        }
        $t->body = $request->body;
        $t->customer_id = auth('customer')->id();
        $t->save();
        return redirect()->back()->with(['message' => __('Ticket has been sent')]);
    }

    public function ticketLang($lang, Ticket $ticket)
    {
        return $this->ticket($ticket);
    }

    public function ticket(Ticket $ticket)
    {
        if ($ticket->customer_id != auth('customer')->id()) {
            return abort(403);
        }
        return view('website.ticket', compact('ticket'));
    }

    public function credit(Invoice $invoice)
    {
        $c = Customer::whereId(auth('customer')->id())->first();
        if ($c->credit == 0) {
            return redirect()->back()->with(['error' => __("You don't have any credit")]);
        }
        if ($c->credit > $invoice->total_price) {
            $invoice->credit_price = $invoice->total_price;
            $invoice->status = Invoice::COMPLETED;
            $c->credit = $c->credit - $invoice->total_price;
        } else {
            $invoice->credit_price = $c->credit;
            $c->credit = 0;
        }
        $invoice->save();
        $c->save();
        $cr = new Credit();
        $cr->invoice_id = $invoice->id;
        $cr->customer_id = $c->id;
        $cr->amount = $invoice->credit_price;
        $cr->save();
        return redirect()->route('customer')->with(['message' => __('Credit applied')]);
    }

    public function saveAddress(AddressSaveRequest $request)
    {
        $ad = new Address();
        $ad->address = $request->address;
        $ad->customer_id = auth('customer')->id();
        $ad->state = $request->state;
        $ad->city = $request->city;
        $ad->data = '{}';
        $ad->save();
        return redirect()->route('customer')->with(['message' => __('Address saved')]);
    }

    public function remAddressLang($lang, Address $address)
    {
        return $this->remAddress($address);
    }

    public function remAddress(Address $address)
    {
        if ($address->customer_id == auth('customer')->id()) {
            $address->delete();
        }
        return redirect()->route('customer')->with(['message' => __('Address removed')]);
    }
}
