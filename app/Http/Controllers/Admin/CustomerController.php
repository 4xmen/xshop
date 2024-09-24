<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\CustomerSaveRequest;
use App\Models\Access;
use App\Models\Credit;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Helper;
use Spatie\Image\Image;
use function App\Helpers\hasCreateRoute;

class CustomerController extends XController
{

    // protected  $_MODEL_ = Customer::class;
    // protected  $SAVE_REQUEST = CustomerSaveRequest::class;

    protected $cols = ['name','mobile','email'];
    protected $extra_cols = ['id'];

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

//        dd($request->all());

        $customer->name = $request->input('name');
        if ($customer->credit != $request->input('credit') && $customer->id != null){
            $diff =  $request->input('credit') - $customer->credit;
            $customer->credit = $request->input('credit')??0 ;
            $cr = new Credit();
            $cr->customer_id = $customer->id;
            $cr->amount = $diff;
            $cr->data = json_encode([
                'user_id' => auth()->user()->id,
                'message' => __("Increase / decrease by Admin"),
            ]);
            $cr->save();
        }
        if ($request->has('email')) {
            $customer->email = $request->input('email');
        }
        $customer->mobile = $request->input('mobile');
        $customer->sex = $request->input('sex');
        if ($request->has('height') && trim($request->input('height')) != '') {
            $customer->height = $request->input('height',null);
        }
        if ($request->has('weight') && trim($request->input('weight')) != '') {
            $customer->weight = $request->input('weight', null);
        }
        $customer->description = $request->input('description');

        if (trim($request->input('password')) != '') {
            $customer->password = bcrypt($request->input('password'));
        }

        if ($request->has('dob') && $request->dob != ''){
            $customer->dob = date('Y-m-d',floor($request->dob));
        }else{
            $customer->dob = null;
        }

        if ($request->hasFile('avatar')) {
            $name = time() . '.' . request()->avatar->getClientOriginalExtension();
            $customer->avatar = $name;
            $request->file('avatar')->storeAs('public/customers', $name);
            $format = $request->file('avatar')->guessExtension();
            $format = 'webp';
            $key = 'avatar';

            $i = Image::load($request->file($key)->getPathname())
                ->optimize()
                ->width(500)
                ->height(500)
                ->crop(500, 500)
//                ->nonQueued()
                ->format($format);
            $i->save(storage_path() . '/app/public/customers/'. $customer->avatar);
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
