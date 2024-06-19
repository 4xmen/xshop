<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function save(Address $address, Request $request)
    {
        $address->address = $request->input('address');
        $address->lat = $request->input('lat');
        $address->lng = $request->input('lng');
        $address->state_id = $request->input('state_id')??null;
        $address->city_id = $request->input('city_id')??null;
        $address->zip = $request->input('zip');
        $address->save();
        return $address;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Customer $item)
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
        $address->customer_id = $item->id;
        $address = $this->save($address, $request);
        logAdmin(__METHOD__,Address::class,$address->id);
        return ['OK' => true,'message' => __("Address added to :CUSTOMER",['CUSTOMER'=>$item->name]), 'list'=> $item->addresses];

    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Address $item)
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
        $this->save($item, $request);
        logAdmin(__METHOD__,Address::class,$item->id);
        return ['OK' => true, "message" => __("address updated")];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $item)
    {
        //
        $add = $item->address ;

        logAdmin(__METHOD__,Address::class,$item->id);
        $item->delete();
        return ['OK' => true, "message" => __(":ADDRESS removed",['ADDRESS' => $add])];
    }


    public function customer(Customer $item)
    {
        return $item->addresses;
    }
}
