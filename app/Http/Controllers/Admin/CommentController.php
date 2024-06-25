<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\CommentSaveRequest;
use App\Models\Access;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class CommentController extends XController
{

    // protected  $_MODEL_ = Comment::class;
    // protected  $SAVE_REQUEST = CommentSaveRequest::class;

    protected $cols = ['*'];
    protected $extra_cols = [];

    protected $searchable = ['body','name','email','ip'];

    protected $listView = 'admin.comments.comment-list';
    protected $formView = 'admin.comments.comment-form';


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
        parent::__construct(Comment::class, CommentSaveRequest::class);
    }

    /**
     * @param $comment Comment
     * @param $request  CommentSaveRequest
     * @return Comment
     */
    public function save($comment, $request)
    {

        $comment->save();
        return $comment;

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
    public function edit(Comment $item)
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
            case 'status':
            $this->_MODEL_::whereIn('id', $request->input('id'))->update(['status' => $data[1]]);
            $msg = __(':COUNT items changed status successfully', ['COUNT' => count($ids)]);
            break;
            default:
                $msg = __('Unknown bulk action : :ACTION', ["ACTION" => $action]);
        }

        return $this->do_bulk($msg, $action, $ids);
    }

    public function destroy(Comment $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Comment $item)
    {
        return $this->bringUp($request, $item);
    }
    public function status( Comment $item, $status)
    {
        $item->status = $status;
        $item->save();
        $statuses = [
            -1 => __('rejected'),
            0 => __('pending'),
            1 => __('approved')
        ];
        return redirect()->back()->with(['message'=> __('Comment :STATUS',['STATUS' => $statuses[$status]]) ]);
    }

    public function reply(Comment $item){

        return view('admin.comments.comment-reply',compact('item'));
    }
    public function replying(Comment $item){

        $c = new Comment();
        $c->ip = \request()->ip();
        $c->commentator_type = User::class;
        $c->commentator_id = auth()->id();
        $c->commentable_type = $item->commentable_type;
        $c->commentable_id = $item->commentable_id;
        $c->parent_id = $item->id;
        $c->status = 1;
        $c->body = \request()->input('body');
        $c->save();

        return redirect()->route('admin.comment.index')->with(['message'=> __('Comment replay')]);
    }

}
