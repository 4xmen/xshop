<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\PropSaveRequest;
use App\Models\Access;
use App\Models\Category;
use App\Models\Prop;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class PropController extends XController
{

    // protected  $_MODEL_ = Prop::class;
    // protected  $SAVE_REQUEST = PropSaveRequest::class;

    protected $cols = ['name','label','icon'];
    protected $extra_cols = ['id'];

    protected $searchable = ['name','label'];

    protected $listView = 'admin.props.prop-list';
    protected $formView = 'admin.props.prop-form';


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
        parent::__construct(Prop::class, PropSaveRequest::class);
    }

    /**
     * @param $prop Prop
     * @param $request  PropSaveRequest
     * @return Prop
     */
    public function save($prop, $request)
    {

//        dd($request->all());
        $prop->name = $request->input('name');
        $prop->type = $request->input('type');
        $prop->required = $request->input('required');
        $prop->searchable = $request->input('searchable');
        $prop->width = $request->input('width');
        $prop->label = $request->input('label');
        $prop->unit = $request->input('unit');
        $prop->priceable = $request->has('priceable');
        $prop->icon = $request->input('icon');


        $data = [];
        if (($request->has('options')) && $request->input('options') != null && $request->input('options') != ''){
            $data = $request->input('options');
        }
        $prop->options = $data;
        $prop->save();
        $prop->categories()->sync($request->input('cat'));
        return $prop;

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
    public function edit(Prop $item)
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
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Prop $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Prop $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Prop::withTrashed()->where('id', $item)->first());
    }
    /*restore**/


    public function sort(){
        return view('admin.props.prop-sort');
    }

    public function sortSave(Request $request){
        foreach ($request->input('items') as $key => $v){

            $p = Prop::whereId($v['id'])->first();
            $p->sort = $key;
            $p->save();
        }
        logAdmin(__METHOD__,__CLASS__,null);
        return ['OK' => true,'message' => __("As you wished sort saved")];
    }
}
