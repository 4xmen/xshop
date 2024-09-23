<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\EvaluationSaveRequest;
use App\Models\Access;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class EvaluationController extends XController
{

    // protected  $_MODEL_ = Evaluation::class;
    // protected  $SAVE_REQUEST = EvaluationSaveRequest::class;

    protected $cols = ['title'];
    protected $extra_cols = ['id'];

    protected $searchable = ['title'];

    protected $listView = 'admin.evaluations.evaluation-list';
    protected $formView = 'admin.evaluations.evaluation-form';


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
        parent::__construct(Evaluation::class, EvaluationSaveRequest::class);
    }

    /**
     * @param $evaluation Evaluation
     * @param $request  EvaluationSaveRequest
     * @return Evaluation
     */
    public function save($evaluation, $request)
    {

        $evaluation->title = $request->title;
        if ($request->evaluationable_type == null || $request->evaluationable_type == '') {
            $evaluation->evaluationable_type = null;
        }else{
            $evaluation->evaluationable_type =  $request->evaluationable_type ;
        }
        if ($request->evaluationable_id == null || $request->evaluationable_id == '') {
            $evaluation->evaluationable_id = null;
        }else{
            $evaluation->evaluationable_id =  $request->evaluationable_id ;

        }
        $evaluation->save();
        return $evaluation;

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
    public function edit(Evaluation $item)
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

    public function destroy(Evaluation $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Evaluation $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Evaluation::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
