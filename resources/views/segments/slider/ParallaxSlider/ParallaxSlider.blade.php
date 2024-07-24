<section id='ParallaxSlider'>
    <div id="ParallaxSliderTns">
        @foreach(\App\Models\Slider::where('status',1)->get() as $slider)
            <div>
                <div class="parallax-slider" data-bg="{{$slider->imgUrl()}}"></div>
                <div class="parallax-slide-item">
                    <div class="main-content">
                        {!! $slider->body !!}
                        <br>
                        <p class="text-center">
                            {{$slider->dataz['index_ParallaxSlider_subtitle']}}
                            <br>
                            <a class="btn btn-outline-dark mt-5"
                               href="{{$slider->dataz['index_ParallaxSlider_link']}}">
                                {{$slider->dataz['index_ParallaxSlider_btn']}}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

