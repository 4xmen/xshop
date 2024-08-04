<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\ClipSaveRequest;
use App\Models\Access;
use App\Models\Clip;
use Illuminate\Http\Request;
use App\Helper;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;
use function App\Helpers\hasCreateRoute;

class ClipController extends XController
{

    // protected  $_MODEL_ = Clip::class;
    // protected  $SAVE_REQUEST = ClipSaveRequest::class;

    protected $cols = ['title','status'];
    protected $extra_cols = ['id','slug','cover'];

    protected $searchable = ['title','body'];

    protected $listView = 'admin.clips.clip-list';
    protected $formView = 'admin.clips.clip-form';


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
        parent::__construct(Clip::class, ClipSaveRequest::class);
    }

    /**
     * @param $clip Clip
     * @param $request  ClipSaveRequest
     * @return Clip
     */
    public function save($clip, $request)
    {


        $clip->title = $request->input('title');
        $clip->slug = $this->getSlug($clip,'slug','title');
        $clip->body = $request->input('body');
        $clip->user_id = auth()->id();
        $clip->status = $request->input('status');
//        if ($request->hasFile('clip')) {
//            $name = $clip->slug . '.' . request()->clip->getClientOriginalExtension();
//            $clip->file = $name;
//            $request->file('clip')->storeAs('public/clips', $name);
//        }
//        if ($request->hasFile('cover')) {
//            $name = $clip->slug . '.' . request()->cover->getClientOriginalExtension();
//            $clip->cover = $name;
//            $request->file('cover')->storeAs('public/clips', $name);
//        }
        if ($request->has('cover')){
            $clip->cover = $this->storeFile('cover',$clip, 'clips');

            $key = 'cover';
            $format = $request->file($key)->guessExtension();
            if (strtolower($format) == 'png'){
                $format = 'webp';
            }
            $i = Image::load($request->file($key)->getPathname())
                ->optimize()
//                ->nonQueued()
                ->format($format);
            if (getSetting('watermark2')) {
                $i->watermark(public_path('upload/images/logo.png'),
                    AlignPosition::BottomLeft, 5, 5, Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent,
                    config('app.media.watermark_size'), Unit::Percent, Fit::Contain,
                    config('app.media.watermark_opacity'));
            }
            if (!file_exists(storage_path() . '/app/public/cover')){
                mkdir(storage_path() . '/app/public/cover/');
            }
            $i->save(storage_path() . '/app/public/cover/optimized-'. $clip->$key);
        }



        if ($request->has('clip')){
            $clip->file = $this->storeFile('clip',$clip, 'clips');
        }
        $clip->save();
        $tags = array_filter(explode(',,', $request->input('tags')));

        if (count($tags) > 0){
            $clip->syncTags($tags);
        }
        return $clip;

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
    public function edit(Clip $item)
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

    public function destroy(Clip $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Clip $item)
    {
        return $this->bringUp($request, $item);
    }

    /**restore*/
    public function restore($item)
    {
        return parent::restoreing(Clip::withTrashed()->where('id', $item)->first());
    }
    /*restore**/
}
