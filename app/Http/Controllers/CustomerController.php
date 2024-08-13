<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;

class CustomerController extends Controller
{
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
        return $invoice;
    }

}
