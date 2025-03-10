<section class="ModernSlider live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div id="ModernSlider">
        @foreach(\App\Models\Slider::where('status',1)->get() as $slider)
            <div class="item">
                <div class="modern-slider" style="background-image: url('{{$slider->imgUrl()}}')">
                    <div class="modern-slide-item">
                        <div class="main-content main-dir">
                            {!! $slider->body !!}
                            <br>
                            <p class="text-center">
                                {{$slider->dataz[$data->area_name.'_'.$data->part.'_subtitle']}}
                                <br>
                                <a class="btn btn-outline-primary mt-5"
                                   href="{{fixUrlLang($slider->dataz[$data->area_name.'_'.$data->part.'_link'])}}">
                                    {{$slider->dataz[$data->area_name.'_'.$data->part.'_btn']}}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
