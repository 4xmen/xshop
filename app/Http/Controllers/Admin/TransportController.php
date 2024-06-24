<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\TransportSaveRequest;
use App\Models\Access;
use App\Models\Transport;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class TransportController extends XController
{

    // protected  $_MODEL_ = Transport::class;
    // protected  $SAVE_REQUEST = TransportSaveRequest::class;

    protected $cols = ['title','price','is_default','icon'];
    protected $extra_cols = ['id'];

    protected $searchable = ['title','description'];

    protected $listView = 'admin.transports.transport-list';
    protected $formView = 'admin.transports.transport-form';


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
        parent::__construct(Transport::class, TransportSaveRequest::class);
    }

    /**
     * @param $transport Transport
     * @param $request  TransportSaveRequest
     * @return Transport
     */
    public function save($transport, $request)
    {

        $transport->price = $request->price;
        $transport->title = $request->title;
        $transport->icon = $request->icon;
        $transport->description = $request->description;
        $transport->is_default = $request->has('is_default');
        if ($request->has('is_default')){
            Transport::where('is_default',1)->where('id','<>',$transport->id)->update([
                'is_default' =>  0,
            ]);
            $transport->is_default = 1;
        }
        $transport->save();
        return $transport;

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
    public function edit(Transport $item)
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

    public function destroy(Transport $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Transport $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Transport::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
