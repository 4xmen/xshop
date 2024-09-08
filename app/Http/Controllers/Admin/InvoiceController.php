<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\InvoiceSaveRequest;
use App\Models\Access;
use App\Models\Credit;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class InvoiceController extends XController
{

    // protected  $_MODEL_ = Invoice::class;
    // protected  $SAVE_REQUEST = InvoiceSaveRequest::class;

    protected $cols = ['hash', 'customer_id', 'count', 'total_price', 'status'];
    protected $extra_cols = ['id'];

    protected $searchable = ['desc'];

    protected $listView = 'admin.invoices.invoice-list';
    protected $formView = 'admin.invoices.invoice-form';


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
        parent::__construct(Invoice::class, InvoiceSaveRequest::class);
    }

    /**
     * @param $invoice Invoice
     * @param $request  InvoiceSaveRequest
     * @return Invoice
     */
    public function save($invoice, $request)
    {

        if($invoice->tracking_code != $request->get('tracking_code') && strlen(trim($request->tracking_code)) == 24){
            if (config('app.sms.driver') == 'Kavenegar'){
                $args = [
                    'receptor' => $invoice->customer->mobile,
                    'template' => trim(getSetting('sent')),
                    'token' => trim($request->tracking_code)
                ];
            }else{
                $args = [
                    'code' => trim($request->tracking_code),
                ];
            }

            sendingSMS(getSetting('sent'),$invoice->customer->mobile,$args);
        }

        $invoice->transport_id = $request->input('transport_id', null);
        $invoice->address_id = $request->input('address_id', null);
        $invoice->tracking_code = $request->tracking_code;
        $invoice->status = $request->status;
        $invoice->save();
        return $invoice;

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
    public function edit(Invoice $item)
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

    public function destroy(Invoice $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Invoice $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Invoice::withTrashed()->where('id', $item)->first());
    }

    public function removeOrder(Order $order)
    {

        $customer = Customer::whereId($order->invoice->customer_id)->first();
        if ($order->price_total > 0) {
            $diff = $order->price_total;
            $customer->credit += $diff;
            $customer->save();
            $cr = new Credit();
            $cr->customer_id = $customer->id;
            $cr->amount = $diff;
            $cr->data = json_encode([
                'user_id' => auth()->user()->id,
                'message' => __("Increase by Admin removed:") . ' ' . $order->product->name . __("Invoice") . ' : ' . $order->invoice->hash,
            ]);
            $cr->save();
            $order->delete();
        }
        return redirect()->back()->with('message', __('Order removed successfully'));
    }
    /*restore**/
}
