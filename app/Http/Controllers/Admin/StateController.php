<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\StateSaveRequest;
use App\Models\Access;
use App\Models\State;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class StateController extends XController
{

    // protected  $_MODEL_ = State::class;
    // protected  $SAVE_REQUEST = StateSaveRequest::class;

    protected $cols = ['name','country'];
    protected $extra_cols = ['id'];

    protected $searchable = [];

    protected $listView = 'admin.states.state-list';
    protected $formView = 'admin.states.state-form';


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
        parent::__construct(State::class, StateSaveRequest::class);
    }

    /**
     * @param $state State
     * @param $request  StateSaveRequest
     * @return State
     */
    public function save($state, $request)
    {


        $state->name = $request->name;
        $state->country = $request->country;
        $state->lat = $request->lat;
        $state->lng = $request->lng;
        $state->save();
        return $state;

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
    public function edit(State $item)
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

    public function destroy(State $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, State $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(State::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
