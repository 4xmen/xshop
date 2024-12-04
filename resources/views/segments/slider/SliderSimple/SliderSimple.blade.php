<div class='slider-content live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class='SliderSimple'>
        @foreach(\App\Models\Slider::where('status',1)->get() as $slider)
            <div class="item">
                <img  src="{{$slider->imgUrl()}}" alt="{{strip_tags($slider->body)}}" >
                <div class="desc">
                    {!! $slider->body !!}
                </div>
            </div>
        @endforeach
    </div>

</div>
