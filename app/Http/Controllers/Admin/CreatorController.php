<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\CreatorSaveRequest;
use App\Models\Access;
use App\Models\Creator;
use Illuminate\Http\Request;
use App\Helper;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;
use function App\Helpers\hasCreateRoute;

class CreatorController extends XController
{

    // protected  $_MODEL_ = Creator::class;
    // protected  $SAVE_REQUEST = CreatorSaveRequest::class;

    protected $cols = ['name','subtitle','parent_id'];
    protected $extra_cols = ['id','slug','image'];

    protected $searchable = ['name','subtitle','description'];

    protected $listView = 'admin.creators.creator-list';
    protected $formView = 'admin.creators.creator-form';

    protected $with = ['parent'];

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
        parent::__construct(Creator::class, CreatorSaveRequest::class);
    }

    /**
     * @param $creator Creator
     * @param $request  CreatorSaveRequest
     * @return Creator
     */
    public function save($creator, $request)
    {
        $target = 'creator';


        $creator->name = $request->input('name');
        $creator->subtitle = $request->input('subtitle');
        $creator->description = $request->input('description');

        if ($request->input('parent_id') == ''){
            $creator->parent_id = null;
        }else{
            $creator->parent_id = $request->input('parent_id',null);
        }

        if ($request->has('canonical') && trim($request->input('canonical')) != ''){
            $creator->canonical = $request->input('canonical');
        }
        $creator->slug = $this->getSlug($creator);

        if ($request->has('image')) {
            $creator->image = substr($this->storeFile('image', $creator, $target),strlen($target)+1);
            $key = 'image';
//            $format = $request->file($key)->guessExtension();
//            if (strtolower($format) == 'png') {
//                $format = 'webp';
//            }

            $this->saveImage($creator, $key, $target);

        }


        $creator->save();
        return $creator;

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cats = Creator::all();
        return view($this->formView, compact('cats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Creator $item)
    {
        $cats = Creator::where('id','<>',$item->id)->get();
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

            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Creator $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Creator $item)
    {
        return $this->bringUp($request, $item);
    }


    public function sort(){
        $items = Creator::orderBy('sort')
            ->get(['id','name','parent_id']);
        return view('admin.commons.sort',compact('items'));
    }

    public function sortSave(Request $request){
//        return $request->items;
        foreach ($request->items as $key => $item){
            $i = Creator::whereId($item['id'])->first();
            $i->sort = $key;
            $i->parent_id = $item['parentId']??null;
            $i->save();
        }
        logAdmin(__METHOD__,__CLASS__,null);
        return ['OK' => true,'message' => __("As you wished sort saved")];
    }

}
