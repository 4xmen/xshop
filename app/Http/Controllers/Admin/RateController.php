<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\RateSaveRequest;
use App\Models\Access;
use App\Models\Rate;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class RateController extends XController
{

    // protected  $_MODEL_ = Rate::class;
    // protected  $SAVE_REQUEST = RateSaveRequest::class;

    protected $cols = ['rateable_type', 'rateable_id', 'rater_type', 'rater_id', 'rate','evaluation_id'];
    protected $extra_cols = ['id'];

    protected $searchable = ['rate','rateable_type','rateable_id', 'rater_type', 'rater_id'];

    protected $listView = 'admin.rates.rate-list';
    protected $formView = 'admin.rates.rate-form';


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
        parent::__construct(Rate::class, RateSaveRequest::class);
    }

    /**
     * @param $rate Rate
     * @param $request  RateSaveRequest
     * @return Rate
     */
    public function save($rate, $request)
    {

        $rate->save();
        return $rate;

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
    public function edit(Rate $item)
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

    public function destroy(Rate $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Rate $item)
    {
        return $this->bringUp($request, $item);
    }


}
