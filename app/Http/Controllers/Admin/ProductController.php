<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\ProductSaveRequest;
use App\Models\Access;
use App\Models\Category;
use App\Models\Product;
use App\Models\Quantity;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class ProductController extends XController
{

    // protected  $_MODEL_ = Product::class;
    // protected  $SAVE_REQUEST = ProductSaveRequest::class;

    protected $cols = ['name','category_id','view','sell','status'];
    protected $extra_cols = ['id','slug','image_index'];

    protected $searchable = ['name','slug','description','excerpt','sku','table'];

    protected $listView = 'admin.products.product-list';
    protected $formView = 'admin.products.product-form';

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
        parent::__construct(Product::class, ProductSaveRequest::class);
    }

    /**
     * @param $product Product
     * @param $request  ProductSaveRequest
     * @return Product
     */
    public function save($product, $request)
    {

//        dd($request->all());
        $product->name = $request->input('name');
        $product->slug = $this->getSlug($product,'slug','name');

        $product->table = $request->input('table');
        $product->description = $request->input('desc');
        $product->excerpt = $request->input('excerpt');
        $product->keyword = $request->input('keyword');
        $product->stock_status = $request->input('stock_status');
        $product->price = $request->input('price',0);
        $product->buy_price = $request->input('buy_price',0);

        if (!$request->has('quantity')) {
            $product->price = $request->input('price',0);
            $product->stock_quantity = $request->input('stock_quantity');
        }
        $product->average_rating = $request->input('average_rating', 0);
        $product->average_rating = $request->input('average_rating', 0);
        $product->rating_count = $request->input('rating_count', 0);
        $product->on_sale = $request->input('on_sale', 1);
        $product->sku = $request->input('sku', null);
        $product->virtual = $request->input('virtual', false);
        $product->downloadable = $request->input('downloadable', false);
        $product->category_id = $request->input('category_id');
        $product->image_index = $request->input('index_image',0);
        $product->user_id = auth()->id();
        $product->status = $request->input('status');
        $tags = array_filter(explode(',,', $request->input('tags')));
        if ($request->has('canonical') && trim($request->input('canonical')) != ''){
            $product->canonical = $request->input('canonical');
        }

        $product->save();
        $product->categories()->sync($request->input('cat'));
        if (count($tags) > 0){
            $product->syncTags($tags);
        }

        foreach ($product->getMedia() as $media) {
            in_array($media->id, request('medias', [])) ?: $media->delete();
        }
        foreach ($request->file('image', []) as $image) {
            try {
                $product->addMedia($image)
                    ->preservingOriginal() //middle method
                    ->toMediaCollection(); //finishing method
            } catch (FileDoesNotExist $e) {
            } catch (FileIsTooBig $e) {
            }
        }

        if ($request->has('meta')) {
//            dd($request->input('meta'));
            $product->syncMeta(json_decode($request->get('meta','[]'),true));
        }
        $toRemoveQ = $product->quantities()->pluck('id')->toArray();
        if ($request->has('q')){
            $qz = json_decode($request->input('q'));
            foreach ($qz as $qi){
                if ($qi->id == null){
                    $q = new Quantity();
                }else{
                    $q = Quantity::whereId($qi->id)->first();
                    unset($toRemoveQ[array_search($q->id, $toRemoveQ) ]); // remove for to remove IDz
                }
                $q->image = $qi->image;
                $q->count = $qi->count;
                $q->price = $qi->price;
                $q->product_id = $product->id;
                $q->data = json_encode($qi->data);
                $q->save();
            }
            $product->quantities()->whereIn('id',$toRemoveQ)->delete();

            if ($product->quantities()->count() > 0){
                $product->stock_quantity = $product->quantities()->sum('count');
                $product->price = $product->quantities()->min('price');
            }
            $product->save();
        }


        return $product;

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cats = Category::all(['id','name','parent_id']);
        return view($this->formView,compact('cats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $item)
    {
        //

        $cats = Category::all(['id','name','parent_id']);
        return view($this->formView, compact('item','cats'));
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
            case 'publish':
                $this->_MODEL_::whereIn('id', $request->input('id'))->update(['status' => 1]);
                $msg = __(':COUNT items published successfully', ['COUNT' => count($ids)]);
                break;
            case 'draft':
                $this->_MODEL_::whereIn('id', $request->input('id'))->update(['status' => 0]);
                $msg = __(':COUNT items drafted successfully', ['COUNT' => count($ids)]);
                break;
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Product $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Product $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Product::withTrashed()->where('id', $item)->first());
    }

    /*restore**/
}
