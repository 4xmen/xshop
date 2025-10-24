<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\StorySaveRequest;
use App\Models\Access;
use App\Models\Story;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class StoryController extends XController
{

    // protected  $_MODEL_ = Story::class;
    // protected  $SAVE_REQUEST = StorySaveRequest::class;

    protected $cols = ['title', 'description','status'];
    protected $extra_cols = ['id', 'image','slug'];

    protected $searchable = ['title', 'description'];

    protected $listView = 'admin.stories.story-list';
    protected $formView = 'admin.stories.story-form';


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
        parent::__construct(Story::class, StorySaveRequest::class);
    }

    /**
     * @param $story Story
     * @param $request  StorySaveRequest
     * @return Story
     */
    public function save($story, $request)
    {

        $target = 'stories' ;
        $story->title = $request->title;
        $story->description = $request->description;
        $story->status = $request->input('status');
        $story->slug = $this->getSlug($story,'slug','title');
        if ($request->has('image')) {
            $story->image = substr($this->storeFile('image', $story, $target),strlen($target)+1);
            $key = 'image';
            $this->saveImage($story, $key, $target);
        }
        if ($request->has('file')){
            $story->file = $this->storeFile('file',$story, $target);
            $story->ext = $request->file('file')->getClientOriginalExtension();
        }
        $story->save();
        return $story;

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
    public function edit(Story $item)
    {
        //
        return view($this->formView, compact('item'));
    }

    public function bulk(Request $request)
    {

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

    public function destroy(Story $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Story $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Story::withTrashed()->where('id', $item)->first());
    }
    /*restore**/

    public function sort()
    {
        $items = Story::where('status',1)-> orderBy('sort')
            ->get(['id', 'title']);
        return view('admin.commons.sort', compact('items'));
    }

    public function sortSave(Request $request){
        foreach ($request->input('items') as $key => $v){

            $p = Story::whereId($v['id'])->first();
            $p->sort = $key;
            $p->save();
        }
        logAdmin(__METHOD__,__CLASS__,null);
        return ['OK' => true,'message' => __("As you wished sort saved")];
    }
}
