<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\XController;
use App\Http\Requests\SliderSaveRequest;
use App\Models\Access;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Helper;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;
use function App\Helpers\hasCreateRoute;

class SliderController extends XController
{

    // protected  $_MODEL_ = Slider::class;
    // protected  $SAVE_REQUEST = SliderSaveRequest::class;

    protected $cols = ['body','status'];
    protected $extra_cols = ['id','image'];

    protected $searchable = ['body'];

    protected $listView = 'admin.sliders.slider-list';
    protected $formView = 'admin.sliders.slider-form';


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
        parent::__construct(Slider::class, SliderSaveRequest::class);
    }

    /**
     * @param $slider Slider
     * @param $request  SliderSaveRequest
     * @return Slider
     */
    public function save($slider, $request)
    {

        $slider->body = $request->input('body', '');
        $slider->status = $request->input('status');
        $slider->data = $request->input('data');
        $slider->user_id = auth()->id();
        if ($request->hasFile('cover')) {
            $name = time() . '.' . request()->cover->getClientOriginalExtension();
            $slider->image = $name;
            $request->file('cover')->storeAs('public/sliders', $name);
            $format = $request->file('cover')->guessExtension();
            if (strtolower($format) == 'png'){
                $format = 'webp';
            }
            $key = 'cover';
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
            $i->save(storage_path() . '/app/public/sliders/optimized-'. $slider->image);
        }

        if ($slider->id == null && Slider::count() > 0) {
            $slider->data = Slider::first()->data;
        }

        $slider->save();
        return $slider;

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
    public function edit(Slider $item)
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

    public function destroy(Slider $item)
    {
        return parent::delete($item);
    }


    public function update(Request $request, Slider $item)
    {
        return $this->bringUp($request, $item);
    }


}
