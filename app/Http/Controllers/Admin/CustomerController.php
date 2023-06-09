<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\customerSaveRequest;
use App\Http\Requests\customerUpdateRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function createOrUpdate(Customer $customer, Request $request)
    {
        $credit = str_replace(',', '', $request->input('credit', 0));
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
//        $customer->address_alt = $request->input('address_alt');
        $customer->state = $request->input('state');
        $customer->credit = $credit == null ? 0 : $credit;
        $customer->city = $request->input('city');
        $customer->postal_code = $request->input('postal_code');
        if ($request->has('email')) {
            $customer->email = $request->input('email');
        }
        $customer->mobile = $request->input('mobile');
        $customer->description = $request->input('description');

        if (trim($request->input('password')) != '') {
            $customer->password = bcrypt($request->input('password'));
        }
        $customer->colleague = $request->has('colleague');
        $customer->save();
        return $customer;
    }


    public function bulk(Request $request)
    {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Customers deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Customer::class, $request->input('id'));
                Customer::destroy($request->input('id'));
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.customer.index')->with(['message' => $msg]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $q = Customer::orderByDesc('id');
        if ($request->has('name') && strlen($request->input('name')) > 1) {
            $q->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->has('mobile') && strlen($request->input('mobile')) > 1) {
            $q->where('mobile', 'LIKE', '%' . $request->mobile . '%');
        }

        if ($request->has('colleague')) {
            $q->where('colleague', true);
        }

        $customers = $q->paginate(20);
        return view('admin.customer.customerIndex', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $customers = Customer::all();
        return view('admin.customer.customerForm', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(customerSaveRequest $request)
    {
        //
        $customer = new Customer();
        $customer = $this->createOrUpdate($customer, $request);
        logAdmin(__METHOD__, Customer::class, $customer->id);
        return redirect()->route('admin.customer.index')->with(['message' => __('Customer created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
        return view('admin.customer.customerForm', compact('customer'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(customerUpdateRequest $request, Customer $customer)
    {
        //
        $this->createOrUpdate($customer, $request);
        logAdmin(__METHOD__, Customer::class, $customer->id);
        return redirect()->route('admin.customer.index')->with(['message' => __('Customer updated successfully')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
        logAdmin(__METHOD__, Customer::class, $customer->id);
        $customer->delete();
        return redirect()->route('admin.customer.index')->with(['message' => __('Customer deleted successfully')]);
    }

}
