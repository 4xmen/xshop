<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Http\Request;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;

class DiscountController extends Controller
{


    public function createOrUpdate(Discount $discount,DiscountRequest $request){
        if ($request->product_id != ''){
            $discount->product_id = $request->product_id;
        }
        $discount->amount = $request->amount;
        $discount->expire = date('Y-m-d',floor($request->expire/1000));
        $discount->code = $request->code;
        $discount->type = $request->type;
        $discount->save();
        return $discount;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $discounts = Discount::paginate(10);
        return  view('admin.discount.discountIndex',compact('discounts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $products = Product::get(['id','name']);
        return view('admin.discount.discountForm',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        //
        $discount = new Discount();
        $discount = $this->createOrUpdate($discount, $request);
        logAdmin(__METHOD__, Discount::class, $discount->id);
        return redirect()->route('admin.discount.index')->with(['message' => __('Discount') . ' ' . __('created successfully')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
        $products = Product::get(['id','name']);
        return view('admin.discount.discountForm',compact('products','discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        $discount = $this->createOrUpdate($discount, $request);
        logAdmin(__METHOD__, Discount::class, $discount->id);
        return redirect()->route('admin.discount.index')->with(['message' => __('Discount') . ' ' . __('updated successfully')]);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        //
        logAdmin(__METHOD__, Discount::class, $discount->id);
        $discount->delete();
        return redirect()->route('admin.discount.index')->with(['message' => __('Discount') . ' ' . __('deleted successfully')]);
    }


    public function bulk(Request $request)
    {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Product deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Discount::class, $request->input('id'));
                Discount::destroy($request->input('id'));
                break;
            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.discount.index')->with(['message' => $msg]);
    }
}
