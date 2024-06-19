<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\CustomerSaveRequest;
use App\Models\Access;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class CustomerController extends XController
{

    // protected  $_MODEL_ = Customer::class;
    // protected  $SAVE_REQUEST = CustomerSaveRequest::class;

    protected $cols = ['name','mobile','email'];
    protected $extra_cols = ['id','deleted_at'];

    protected $searchable = ['name','mobile','email'];

    protected $listView = 'admin.customers.customer-list';
    protected $formView = 'admin.customers.customer-form';


    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
        'show' =>
            ['title' => "Detail", 'class' => 'btn-outline-light', 'icon' => 'ri-eye-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-close-line'],
    ];


    public function __construct()
    {
        parent::__construct(Customer::class, CustomerSaveRequest::class);
    }

    /**
     * @param $customer Customer
     * @param $request  CustomerSaveRequest
     * @return Customer
     */
    public function save($customer, $request)
    {

        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->state = $request->input('state');
        $customer->credit = $request->input('credit')??0 ;
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view($this->formView);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $item)
    {
        //
        return view($this->formView, compact('item'));
    }

    public function bulk(Request $request)
    {

//        dd($request->all());
        $data = explode('.', $request->input('action'));
        $action = $data[0];
        $ids = $request->input('id');
        switch ($action) {
            case 'delete':
                $msg = __(':COUNT items deleted successfully', ['COUNT' => count($ids)]);
                $this->_MODEL_::destroy($ids);
                break;
            /**restore*/
            case 'restore':
                $msg = __(':COUNT items restored successfully', ['COUNT' => count($ids)]);
                foreach ($ids as $id) {
                    $this->_MODEL_::withTrashed()->find($id)->restore();
                }
                break;
            /*restore**/
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Customer $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Customer $item)
    {
        return $this->bringUp($request, $item);
    }


    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Customer::withTrashed()->where('id', $item)->first());
    }
    /*restore**/


}
