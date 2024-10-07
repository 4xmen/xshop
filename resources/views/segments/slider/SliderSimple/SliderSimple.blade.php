<div class="slider-content">
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
