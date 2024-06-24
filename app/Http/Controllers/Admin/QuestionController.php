<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\QuestionSaveRequest;
use App\Models\Access;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class QuestionController extends XController
{

    // protected  $_MODEL_ = Question::class;
    // protected  $SAVE_REQUEST = QuestionSaveRequest::class;

    protected $cols = ['body','product_id','status'];
    protected $extra_cols = ['id'];

    protected $searchable = ['body','answer'];

    protected $listView = 'admin.questions.question-list';
    protected $formView = 'admin.questions.question-form';


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
        parent::__construct(Question::class, QuestionSaveRequest::class);
    }

    /**
     * @param $question Question
     * @param $request  QuestionSaveRequest
     * @return Question
     */
    public function save($question, $request)
    {

        $question->body = $request->input('body');
        $question->answer = $request->input('answer');
        $question->status = $request->input('status');
        $question->save();
        return $question;

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
    public function edit(Question $item)
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
            case 'publish':
                $this->_MODEL_::whereIn('id', $request->input('id'))->update(['status' => 1]);
                $msg = __(':COUNT items published successfully', ['COUNT' => count($ids)]);
                break;
            case 'draft':
                $this->_MODEL_::whereIn('id', $request->input('id'))->update(['status' => 0]);
                $msg = __(':COUNT items drafted successfully', ['COUNT' => count($ids)]);
                break;
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Question $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Question $item)
    {
        return $this->bringUp($request, $item);
    }


}
