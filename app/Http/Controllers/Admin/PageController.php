<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\PageSaveRequest;
use App\Models\Access;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class PageController extends XController
{

    // protected  $_MODEL_ = Page::class;
    // protected  $SAVE_REQUEST = PageSaveRequest::class;

    protected $cols =['title','parent_id','status'];
    protected $extra_cols = ['id', 'slug'];

    protected $searchable = ['title','subtitle','body'];

    protected $listView = 'admin.pages.page-list';
    protected $formView = 'admin.pages.page-form';


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
        parent::__construct(Page::class, PageSaveRequest::class);
    }

    /**
     * @param $page Page
     * @param $request  PageSaveRequest
     * @return Page
     */
    public function save($page, $request)
    {

        $page->title = $request->input('title');
        $page->slug = $this->getSlug($page,'slug','title');
        $page->body = $request->input('body');
        $page->subtitle = $request->input('subtitle');
        $page->status = $request->input('status');
        $page->parent_id = $request->input('parent_id');
        $page->icon = $request->input('icon');
        $page->markups = $request->input('markups');
        if ($request->has('canonical') && trim($request->input('canonical')) != ''){
            $page->canonical = $request->input('canonical');
        }
        if ($request->hasFile('image')) {
            $page->media()->delete();
            $page->addMedia($request->file('image'))
                ->preservingOriginal() //middle method
                ->toMediaCollection(); //finishing method
        }
        $page->save();
        return $page;

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $pages = Page::all(['title','id']);
        return view($this->formView, compact('pages'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $item)
    {
        //

        $pages = Page::all(['title','id'])->where('id','!=',$item->id);
        return view($this->formView, compact('item','pages'));
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

    public function destroy(Page $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Page $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Page::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
