<section id='ParallaxSlider' class=' live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div id="ParallaxSliderTns">
        @foreach(\App\Models\Slider::where('status',1)->get() as $slider)
            <div>
                <div class="parallax-slider" data-bg="{{$slider->imgUrl()}}"></div>
                <div class="parallax-slide-item">
                    <div class="main-content main-dir" >
                        {!! $slider->body !!}
                        <br>
                        <p class="text-center">
                            {{$slider->dataz[$data->area_name.'_'.$data->part.'_subtitle']}}
                            <br>
                            <a class="btn btn-outline-dark mt-5"
                               href="{{fixUrlLang($slider->dataz[$data->area_name.'_'.$data->part.'_link'])}}">
                                {{$slider->dataz[$data->area_name.'_'.$data->part.'_btn']}}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

