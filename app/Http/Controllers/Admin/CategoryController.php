<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\CategorySaveRequest;
use App\Models\Access;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helper;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;
use function App\Helpers\hasCreateRoute;

class CategoryController extends XController
{

    // protected  $_MODEL_ = Category::class;
    // protected  $SAVE_REQUEST = CategorySaveRequest::class;

    protected $cols = ['name', 'subtitle', 'parent_id'];
    protected $extra_cols = ['id', 'slug', 'image'];

    protected $searchable = ['name', 'subtitle', 'description'];


    protected $listView = 'admin.categories.category-list';
    protected $formView = 'admin.categories.category-form';


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
        parent::__construct(Category::class, CategorySaveRequest::class);
    }

    /**
     * @param $category Category
     * @param $request  CategorySaveRequest
     * @return Category
     */
    public function save($category, $request)
    {

        $category->name = $request->input('name');
        $category->subtitle = $request->input('subtitle');
        $category->icon = $request->input('icon');
        $category->description = $request->input('description');
        if ($category->parent_id != ''){
            $category->parent_id = $request->input('parent_id',null);
        }
        if ($request->has('canonical') && trim($request->input('canonical')) != ''){
            $category->canonical = $request->input('canonical');
        }
        $category->slug = $this->getSlug($category);
        if ($request->has('image')) {
            $category->image = $this->storeFile('image', $category, 'categories');
            $key = 'image';
            $format = $request->file($key)->guessExtension();
            if (strtolower($format) == 'png'){
                $format = 'webp';
            }
            $i = Image::load($request->file($key)->getPathname())
                ->optimize()
//                ->nonQueued()
                ->format($format);
            if (getSetting('watermark2')) {
                $i->watermark(public_path('upload/images/logo.png'),
                    AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                    config('app.media.watermark_opacity'));
            }
            $i->save(storage_path() . '/app/public/categories/optimized-'. $category->$key);

        }
        if ($request->has('bg')) {
            $category->bg = $this->storeFile('bg', $category, 'categories');
            $key = 'bg';
            $format = $request->file($key)->guessExtension();
            if (strtolower($format) == 'png'){
                $format = 'webp';
            }
            $i = Image::load($request->file($key)->getPathname())
                ->optimize()
//                ->nonQueued()
                ->format($format);
            if (getSetting('watermark2')) {
                $i->watermark(public_path('upload/images/logo.png'),
                    AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                    config('app.media.watermark_opacity'));
            }
            $i->save(storage_path() . '/app/public/categories/optimized-'. $category->$key);
        }

        if ($request->has('svg')){
            $category->svg = $this->storeFile('svg',$category, 'categories');
        }
        $category->save();
        return $category;

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cats = Category::all();
        return view($this->formView, compact('cats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $item)
    {
        //
        $cats = Category::all();
        return view($this->formView, compact('item', 'cats'));
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

    public function destroy(Category $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Category $item)
    {
        return $this->bringUp($request, $item);
    }


    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Category::withTrashed()->where('id', $item)->first());
    }
    /*restore**/


    /**sort*/
    public function sort()
    {
        $items = Category::orderBy('sort')
            ->get(['id', 'name', 'parent_id']);
        return view('admin.commons.sort', compact('items'));
    }

    public function sortSave(Request $request)
    {
//        return $request->items;
        foreach ($request->items as $key => $item) {
            $i = Category::whereId($item['id'])->first();
            $i->sort = $key;
            $i->parent_id = $item['parentId'] ?? null;
            $i->save();
        }
        logAdmin(__METHOD__, __CLASS__, null);
        return ['OK' => true, 'message' => __("As you wished sort saved")];
    }
    /*sort**/


}
