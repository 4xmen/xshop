<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\GallerySaveRequest;
use App\Models\Access;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Helper;
use function App\Helpers\hasCreateRoute;

class GalleryController extends XController
{

    // protected  $_MODEL_ = Gallery::class;
    // protected  $SAVE_REQUEST = GallerySaveRequest::class;

    protected $cols = ['title','status'];
    protected $extra_cols = ['id','slug'];

    protected $searchable = ['title','description'];

    protected $listView = 'admin.galleries.gallery-list';
    protected $formView = 'admin.galleries.gallery-form';


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
        parent::__construct(Gallery::class, GallerySaveRequest::class);
    }

    /**
     * @param $gallery Gallery
     * @param $request  GallerySaveRequest
     * @return Gallery
     */
    public function save($gallery, $request)
    {

        $gallery->title = $request->input('title');
        $gallery->slug = $this->getSlug($gallery,'slug','title');
        $gallery->description = $request->input('description');
        $gallery->status = $request->input('status');
        $gallery->user_id = auth()->id();

        $gallery->save();


        if ($request->hasFile('image')) {
            $gallery->media()->delete();
            $gallery->addMedia($request->file('image'))
                ->preservingOriginal() //middle method
                ->toMediaCollection();
        }
        $gallery->save();
        return $gallery;

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
    public function edit(Gallery $item)
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

    public function destroy(Gallery $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Gallery $item)
    {
        return $this->bringUp($request, $item);
    }


    public function updateTitle(Request $request){
        foreach ($request->titles as $k => $title) {
            $image = Image::whereId($k)->first();
            $image->title = $title;
            $image->save();
        }
        return redirect()->back()->with(['message' => __("Titles updated")]);
    }


}
