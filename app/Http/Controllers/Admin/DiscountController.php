<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\DiscountSaveRequest;
use App\Models\Access;
use App\Models\Discount;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class DiscountController extends XController
{

    // protected  $_MODEL_ = Discount::class;
    // protected  $SAVE_REQUEST = DiscountSaveRequest::class;

    protected $cols = ['title','code','expire','product_id'];
    protected $extra_cols = ['id'];

    protected $searchable = ['title','code','body'];

    protected $listView = 'admin.discounts.discount-list';
    protected $formView = 'admin.discounts.discount-form';


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
        parent::__construct(Discount::class, DiscountSaveRequest::class);
    }

    /**
     * @param $discount Discount
     * @param $request  DiscountSaveRequest
     * @return Discount
     */
    public function save($discount, $request)
    {

        if ($request->product_id != ''){
            $discount->product_id = $request->product_id;
        }
        $discount->title = $request->title;
        $discount->body = $request->body;
        $discount->amount = $request->amount;
        if ($request->has('expire') && $request->expire != ''){
            $discount->expire = date('Y-m-d H:i:s',floor($request->expire));
        }else{
            $discount->expire = null;
        }
        $discount->code = $request->code;
        $discount->type = $request->type;
        $discount->save();
        return $discount;

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
    public function edit(Discount $item)
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

    public function destroy(Discount $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Discount $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Discount::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
