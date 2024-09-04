<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Ticket;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class CustomerController extends Controller
{

    public function addressSave(Address $address, Request $request)
    {
        $address->address = $request->input('address');
        $address->lat = $request->input('lat');
        $address->lng = $request->input('lng');
        $address->state_id = $request->input('state_id') ?? null;
        $address->city_id = $request->input('city_id') ?? null;
        $address->zip = $request->input('zip');
        $address->save();
        return $address;
    }

    //
    public function __construct()
    {


        $this->middleware(function ($request, $next) {

            if (!auth('customer')->check()) {
                return redirect()->route('client.sign-in');
            }

            if (\Session::has('locate')) {
                app()->setLocale(\Session::get('locate'));
            }

            return $next($request);
        });

    }

    public function profile()
    {
        $area = 'customer';
        $title = __("Profile");
        $subtitle = 'You information';
        return view('client.default-list', compact('area', 'title', 'subtitle'));
        return auth('customer')->user();
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'mobile' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $customer = auth('customer')->user();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->mobile = $request->mobile;
        if ($request->has('password') && trim($request->input('password')) != '') {
            $customer->password = bcrypt($request->password);
        }
        $customer->save();
        return redirect()->route('client.profile')->with('message', __('Profile updated successfully'));
    }

    public function invoice(Invoice $invoice)
    {
        if (!auth('customer')->check() || $invoice->customer_id != auth('customer')->id()) {
            return redirect()->route('client.sign-in')->withErrors([__('You need to login to access this page')]);
        }

        $area = 'invoice';
        $title = __("Invoice");
        $subtitle = __("Invoice ID:") . ' ' . $invoice->hash;

        $options = new QROptions([
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel'   => QRCode::ECC_L,
//            'imageTransparent' => true,
        ]);
        $qr = new QRCode($options);
        return view('client.invoice', compact('area', 'title', 'subtitle','invoice','qr'));
    }


    public function ProductFavToggle($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if (!auth('customer')->check()) {
            return errors([
                __("You need to login first"),
            ], 403, __("You need to login first"));
        }

        if (auth('customer')->user()->favorites()->where('product_id', $product->id)->count() == 0) {
            auth('customer')->user()->favorites()->attach($product->id);
            $message = __('Product added to favorites');
            $fav = '1';
        } else {
            auth('customer')->user()->favorites()->detach($product->id);
            $message = __('Product removed from favorites');
            $fav = '0';
        }

        if (\request()->ajax()) {
            return success($fav, $message);
        } else {
            return redirect()->back()->with(['message' => $message]);
        }
    }


    public function addresses()
    {
        return auth('customer')->user()->addresses;
    }


    public function addressUpdate(Request $request, $item)
    {

        $item = Address::where('id', $item)->firstOrFail();
        if ($item->customer_id != auth('customer')->user()->id) {
            return abort(403);
        }
        //
        $request->validate([
            'address' => ['required', 'string', 'min:10'],
            'zip' => ['required', 'string', 'min:5'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'lat' => ['nullable'],
            'lng' => ['nullable'],
        ]);
        $this->addressSave($item, $request);
        return ['OK' => true, "message" => __("address updated")];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function addressDestroy(Address $item)
    {
        //
        if ($item->customer_id != auth('customer')->id()) {
            return abort(403);
        }
        $add = $item->address;

        $item->delete();
        return ['OK' => true, "message" => __(":ADDRESS removed", ['ADDRESS' => $add])];
    }

    public function addressStore(Request $request)
    {
        //

        $request->validate([
            'address' => ['required', 'string', 'min:10'],
            'zip' => ['required', 'string', 'min:5'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'lat' => ['nullable'],
            'lng' => ['nullable'],
        ]);

        $address = new Address();
        $address->customer_id = auth('customer')->user()->id;
        $address = $this->addressSave($address, $request);
        return ['OK' => true, 'message' => __("Address added successfully"), 'list' => auth('customer')->user()->addresses];

    }

    public function submitTicket(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $ticket = new Ticket();
        $ticket->title = $request->title;
        $ticket->body = trim($request->body);
        $ticket->customer_id = auth('customer')->user()->id;
        $ticket->save();
        return redirect()->route('client.profile')->with('message', __('Ticket added successfully'));
    }

    public function showTicket(Ticket $ticket)
    {
        return view('client.ticket', compact('ticket'));
    }


    public function ticketAnswer(Ticket $ticket, Request $request)
    {

        $request->validate([
            'body' => ['required', 'string'],
        ]);

        $ticket->status = "PENDING";
        $ticket->save();

        $nticket = new Ticket();
        $nticket->parent_id = $ticket->id;
        $nticket->body = trim($request->body);
        $nticket->customer_id = auth('customer')->user()->id;
        $nticket->save();
        return redirect(route('client.profile') . '#tickets')->with('message', __('Ticket answered successfully'));
    }


}
