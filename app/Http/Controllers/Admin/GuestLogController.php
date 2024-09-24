<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\GuestLogSaveRequest;
use App\Models\Access;
use App\Models\GuestLog;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class GuestLogController extends XController
{

    // protected  $_MODEL_ = GuestLog::class;
    // protected  $SAVE_REQUEST = GuestLogSaveRequest::class;

    protected $cols = ['ip','action','created_at','loggable_type','loggable_id'];
    protected $extra_cols = ['id'];

    protected $searchable = ['action','ip'];

    protected $listView = 'admin.guestlogs.guestlog-list';
    protected $formView = 'admin.guestlogs.guestlog-form';


    protected $buttons = [
//        'edit' =>
//            ['title' => "Edit", 'class' => 'btn-outline-primary', 'icon' => 'ri-edit-2-line'],
//        'show' =>
//            ['title' => "Detail", 'class' => 'btn-outline-light', 'icon' => 'ri-eye-line'],
//        'destroy' =>
//            ['title' => "Remove", 'class' => 'btn-outline-danger delete-confirm', 'icon' => 'ri-close-line'],
    ];


    public function __construct()
    {
        parent::__construct(GuestLog::class, GuestLogSaveRequest::class);
    }

    /**
     * @param $guestlog GuestLog
     * @param $request  GuestLogSaveRequest
     * @return GuestLog
     */
    public function save($guestlog, $request)
    {

        $guestlog->save();
        return $guestlog;

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
    public function edit(GuestLog $item)
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

    public function destroy(GuestLog $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, GuestLog $item)
    {
        return $this->bringUp($request, $item);
    }


}
