<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\AdvSaveRequest;
use App\Models\Access;
use App\Models\Adv;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class AdvController extends XController
{

    // protected  $_MODEL_ = Adv::class;
    // protected  $SAVE_REQUEST = AdvSaveRequest::class;

    protected $cols = ['title','link'];
    protected $extra_cols = ['id','image'];

    protected $searchable = ['title','link'];

    protected $listView = 'admin.advs.adv-list';
    protected $formView = 'admin.advs.adv-form';


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
        parent::__construct(Adv::class, AdvSaveRequest::class);
    }

    /**
     * @param $adv Adv
     * @param $request  AdvSaveRequest
     * @return Adv
     */
    public function save($adv, $request)
    {

        $adv->title = $request->input('title');
        $adv->max_click = $request->input('max_click');
        $adv->link = $request->input('link');
        $adv->expire = date('Y-m-d',$request->input('expire'));
        $adv->user_id = auth()->id();
        $adv->status = $request->input('status');

        if ($request->has('image')){
            $adv->image = $this->storeFile('image',$adv, 'ad');
        }

        $adv->save();
        return $adv;

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
    public function edit(Adv $item)
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

    public function destroy(Adv $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Adv $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Adv::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
