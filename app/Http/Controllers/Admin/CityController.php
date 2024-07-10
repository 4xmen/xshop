<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\CitySaveRequest;
use App\Models\Access;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class CityController extends XController
{

    // protected  $_MODEL_ = City::class;
    // protected  $SAVE_REQUEST = CitySaveRequest::class;

    protected $cols = ['name','state_id'];
    protected $extra_cols = ['id'];

    protected $searchable = [];

    protected $listView = 'admin.cities.city-list';
    protected $formView = 'admin.cities.city-form';


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
        parent::__construct(City::class, CitySaveRequest::class);
    }

    /**
     * @param $city City
     * @param $request  CitySaveRequest
     * @return City
     */
    public function save($city, $request)
    {

        $city->name = $request->name;
        $city->state_id = $request->state_id;
        $city->lat = $request->lat;
        $city->lng = $request->lng;
        $city->save();
        return $city;

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $states = State::orderBy('name')->get(['id', 'name']);
        return view($this->formView,compact('states'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $item)
    {
        //
        $states = State::orderBy('name')->get(['id', 'name']);
        return view($this->formView, compact('item','states'));
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

    public function destroy(City $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, City $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(City::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
