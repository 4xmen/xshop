<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\PostSaveRequest;
use App\Models\Access;
use App\Models\Group;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class PostController extends XController
{

    // protected  $_MODEL_ = Post::class;
    // protected  $SAVE_REQUEST = PostSaveRequest::class;

    protected $cols = ['title','hash','view','status'];
    protected $extra_cols = ['id', 'slug'];

    protected $searchable = ['title','subtitle','body'];

    protected $listView = 'admin.posts.post-list';
    protected $formView = 'admin.posts.post-form';


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
        parent::__construct(Post::class, PostSaveRequest::class);
    }

    /**
     * @param $post Post
     * @param $request  PostSaveRequest
     * @return Post
     */
    public function save($post, $request)
    {

        $post->title = $request->input('title');
        $post->slug = $this->getSlug($post,'slug','title');
        $post->body = $request->input('body');
        $post->subtitle = $request->input('subtitle');
        $post->status = $request->input('status');
        $post->group_id = $request->input('group_id');
        $post->user_id = auth()->id();
        $post->is_pinned = $request->has('is_pin');
        $post->table_of_contents = $request->has('table_of_contents');
        $post->icon = $request->input('icon');
        $post->keyword = $request->input('keyword');

        if ($request->has('canonical') && trim($request->input('canonical')) != ''){
            $post->canonical = $request->input('canonical');
        }

        if ($post->hash == null) {
            $post->hash = date('Ym') . str_pad(dechex(crc32($post->slug)), 8, '0', STR_PAD_LEFT);
        }

        $post->save();
        $post->groups()->sync($request->input('cat'));
        $tags = array_filter(explode(',,', $request->input('tags')));

        if (count($tags) > 0){
            $post->syncTags($tags);
        }

        if ($request->hasFile('image')) {
            $post->media()->delete();
            $post->addMedia($request->file('image'))
                ->preservingOriginal() //middle method
                ->toMediaCollection(); //finishing method
        }



        return $post;

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $cats = Group::all(['name','id','parent_id']);
        return view($this->formView, compact('cats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $item)
    {
        //
        $cats = Group::all(['name','id','parent_id']);
        return view($this->formView, compact('item', 'cats'));
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

    public function destroy(Post $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Post $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Post::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
