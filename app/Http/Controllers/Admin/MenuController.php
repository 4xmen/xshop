<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\MenuSaveRequest;
use App\Models\Access;
use App\Models\Item;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class MenuController extends XController
{

    // protected  $_MODEL_ = Menu::class;
    // protected  $SAVE_REQUEST = MenuSaveRequest::class;

    protected $cols = ['name'];
    protected $extra_cols = ['id'];

    protected $searchable = ['name'];

    protected $listView = 'admin.menus.menu-list';
    protected $formView = 'admin.menus.menu-form';


    protected $buttons = [
        'edit' =>
            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
//        'show' =>
//            ['title' => "Detail", 'class' => 'btn-outline-light', 'icon' => 'ri-eye-line'],
        'destroy' =>
            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-close-line'],
    ];


    public function __construct()
    {
        parent::__construct(Menu::class, MenuSaveRequest::class);
    }

    /**
     * @param $menu Menu
     * @param $request  MenuSaveRequest
     * @return Menu
     */
    public function save($menu, $request)
    {

        $menu->name = $request->input('name');
        if ($menu->user_id == null){
            $menu->user_id = auth()->user()->id;
        }
        $menu->save();

        $items = json_decode($request->input('items','[]'));
        foreach ($items as $item) {
            if ($item->id == null){
                $i = new Item();
            }else{
                $i = Item::whereId($item->id)->first();
            }
            $i->user_id = auth()->user()->id;
            $i->menu_id = $menu->id;
            $i->meta = $item->meta??null;
            $i->sort = $item->sort;
            $i->parent = $item->parent;
            $i->kind = $item->kind;
            $i->title = $item->title;
            $i->menuable_id = $item->menuable_id??null;
            $i->menuable_type = $item->menuable_type??null;
            $i->save();
        }

        Item::whereIn('id',json_decode($request->input('removed','[]')))->delete();

        return $menu;

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
    public function edit(Menu $item)
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

    public function destroy(Menu $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Menu $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Menu::withTrashed()->where('id', $item)->first());
    }

    public function sort(Menu $item){
        return view('admin.menus.menu-sort', compact('item'));
    }


    public function sortSave(Request $request){
        foreach ($request->input('items') as $key => $v){

            $p = Item::whereId($v['id'])->first();
            $p->sort = $key;
            $p->save();
        }
        logAdmin(__METHOD__,__CLASS__,null);
        return ['OK' => true,'message' => __("As you wished sort saved")];
    }

    /*restore**/
}
