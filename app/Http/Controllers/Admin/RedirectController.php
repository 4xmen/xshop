<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\RedirectSaveRequest;
use App\Models\Access;
use App\Models\Redirect;
use Illuminate\Http\Request;
use App\Helper;
use Illuminate\Support\Facades\Cache;
use function App\Helpers\hasCreateRoute;

class RedirectController extends XController
{

    // protected  $_MODEL_ = Redirect::class;
    // protected  $SAVE_REQUEST = RedirectSaveRequest::class;

    protected $cols = ['source','destination','status'];
    protected $extra_cols = ['id'];

    protected $searchable = ['source','destination'];

    protected $listView = 'admin.redirects.redirect-list';
    protected $formView = 'admin.redirects.redirect-form';


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
        parent::__construct(Redirect::class, RedirectSaveRequest::class);
    }

    /**
     * @param $redirect Redirect
     * @param $request  RedirectSaveRequest
     * @return Redirect
     */
    public function save($redirect, $request)
    {

        $redirect->source = $request->source;
        $redirect->destination = $request->destination;
        $redirect->status = $request->status;
        if ($request->has('expire') && $request->expire != ''){
            $redirect->expire = date('Y-m-d',floor($request->expire));
        }else{
            $redirect->expire = null;
        }
        Cache::forget("redirect:{$redirect->source}");
        $redirect->save();
        return $redirect;

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
    public function edit(Redirect $item)
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

            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Redirect $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Redirect $item)
    {
        return $this->bringUp($request, $item);
    }


}
