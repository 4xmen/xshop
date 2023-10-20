<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSaveRequest;
use App\Models\Cat;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Quantity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Xmen\StarterKit\Helpers\TDate;
use function Xmen\StarterKit\Helpers\logAdmin;
use function Xmen\StarterKit\Helpers\logAdminBatch;
use const http\Client\Curl\VERSIONS;

class ProductController extends Controller
{
    public function createOrUpdate(Product $product, ProductSaveRequest $request)
    {


//        $dt = new TDate();

        $product->name = $request->input('name');
        $product->slug = \StarterKit::slug($request->input('name'));
        $product->description = $request->input('desc');
        $product->excerpt = $request->input('excerpt');
        $product->stock_status = $request->input('stock_status');
        if (!$request->has('quantity')) {
            $product->price = $request->input('price',0);
            $product->stock_quantity = $request->input('stock_quantity');
        }
        $product->virtual = $request->input('virtual', false);
        $product->average_rating = $request->input('average_rating', 0);
        $product->average_rating = $request->input('average_rating', 0);
        $product->rating_count = $request->input('rating_count', 0);
        $product->on_sale = $request->input('on_sale', 1);
        $product->sku = $request->input('sku', null);
        $product->downloadable = $request->input('downloadable', false);
        $product->cat_id = $request->input('cat_id');
        $product->image_index = $request->input('index_image',0);
        $product->user_id = auth()->id();
        $product->active = $request->has('active');

        $product->save();

//        $product->


        $product->retag(explode(',', $request->input('tags')));

        $product->categories()->sync($request->input('cat'));


        if ($request->has('meta')) {
//            dd($request->input('meta'));
            $product->syncMeta($request->get('meta'));
        }


//        if ($request->hasFile('image')) {
//            $product->media()->delete();
//            $product->addMedia($request->file('image'))->toMediaCollection();
//        }


        foreach ($product->getMedia() as $media) {
            in_array($media->id, request('medias', [])) ?: $media->delete();
        }
        foreach ($request->file('image', []) as $image) {
            try {
                $product->addMedia($image)->toMediaCollection();
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($request->has('quantity')) {

            $qs = json_decode($request->input('quantity'), true);


            $product->quantities()->forceDelete();
            $counts = 0;
            foreach ($qs as $q) {
                $t = $q;
                $qn = new Quantity();
                $qn->product_id = $product->id;
                $qn->count = (int) $t['count'];
                $qn->price = (int) $t['price'];
                $qn->image = $t['image'];
                $qn->data = json_encode($t);
                $qn->save();
                $counts += $qn->count;
//            unset($t['count']);
//            unset($t['price']);
//            $qn->syncMeta($t);

            }

            $product->stock_quantity = $counts;
            $product->price =$product->quantities()->min('price');
            $product->save();
        }

        if (trim($request->discount['amount']) != '' ){
            $discount = new Discount();
            $discount->product_id = $product->id;
            $discount->amount = $request->discount['amount'];
            $discount->expire = date('Y-m-d',floor($request->discount['expire']/1000));
//            $discount->code = $request->discount['code'];
            if ($discount->expire == '1970-01-01 00:00:00'){
                $discount->expire = null;
            }
            $discount->type = $request->discount['type'];
            $discount->save();
        }
        if (trim($request->discount['remove']) != '' ){
                Discount::whereIn('id',json_decode($request->discount['remove'],true))->delete();
//            Discount::destroy(json_encode($request->discount['remove'],true));
        }


        return $product;
    }

    public function bulk(Request $request)
    {

        switch ($request->input('bulk')) {
            case 'delete':
                $msg = __('Product deleted successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Product::class, $request->input('id'));
                Product::destroy($request->input('id'));
                break;
            case 'IN_STOCK':
                $msg = __('Product stock changed successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Product::class, $request->input('id'));
                Product::whereIn('id', $request->input('id'))->update(['stock_status' => 'IN_STOCK']);
                break;
            case 'OUT_STOCK':
                $msg = __('Product stock changed successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Product::class, $request->input('id'));
                Product::whereIn('id', $request->input('id'))->update(['stock_status' => 'OUT_STOCK']);
                break;
            case 'OUT_STOCK':
                $msg = __('Product stock changed successfully');
                logAdminBatch(__METHOD__ . '.' . $request->input('bulk'), Product::class, $request->input('id'));
                Product::whereIn('id', $request->input('id'))->update(['stock_status' => 'OUT_STOCK']);
                break;

            default:
                $msg = __('Unknown bulk action :' . $request->input('bulk'));
        }
        return redirect()->route('admin.product.index')->with(['message' => $msg]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //
        $n = Product::orderByDesc('id');
        if ($request->has('filter')) {
            if ($request->filter == 'TRASH'){
                $n = $n->onlyTrashed();
            }else{

                $n = $n->where('stock_status', $request->filter);
            }
        }
        $products = $n->paginate(20);
        return view('admin.product.productIndex', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cats = Cat::all();
        return view('admin.product.productForm', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductSaveRequest $request)
    {
        //

        $product = new Product();
        $product = $this->createOrUpdate($product, $request);
        logAdmin(__METHOD__, Product::class, $product->id);
        if ($request->ajax()) {
            return ['OK' => true, 'url' => route('admin.product.index')];
        } else {
            return redirect()->route('admin.product.index')->with(['message' => $product->name . ' ' . __('created successfully')]);
        }
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
    public function edit(Product $product)
    {
        //
        $cats = Cat::all();
        return view('admin.product.productForm', compact('cats', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductSaveRequest $request, Product $product)
    {
        //

//        return $request->all();
//        return $product;
        $this->createOrUpdate($product, $request);
        logAdmin(__METHOD__, Product::class, $product->id);
        if ($request->ajax()) {
            return ['OK' => true, 'msg' => $product->name . ' ' . __('updated successfully')];
        } else {
            return redirect()->route('admin.product.index')->with(['message' => $product->name . ' ' . __('updated successfully')]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        logAdmin(__METHOD__, Product::class, $product->id);
        $product->delete();
        return redirect()->route('admin.product.index')->with(['message' => __('Product deleted successfully')]);

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($slug)
    {
        //
        $product = Product::withTrashed()->where('slug',$slug)->first();
        logAdmin(__METHOD__, Product::class, $product->id);
        $product->restore();
        return redirect()->back()->with(['message' => __('Product restore successfully')]);

    }
}
