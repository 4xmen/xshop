<section class="DowntownSlider live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div id="downtown-slider">
        @foreach(\App\Models\Slider::where('status',1)->get() as $slider)
            <div class="item">
                <div class="row">
                    <div class="col-6 downtown-img">
                        <img src="{{$slider->imgUrl()}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-6 downtown-content">
                        <img src="{{$slider->imgUrl()}}" alt="">
                        <svg
                            width="145mm"
                            height="145mm"
                            viewBox="0 0 145 145"
                            version="1.1"
                            id="svg5"
                            inkscape:version="1.2.2 (b0a8486541, 2022-12-01)"
                            sodipodi:docname="drawing.svg"
                            xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                            xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:svg="http://www.w3.org/2000/svg">
                            <sodipodi:namedview
                                id="namedview7"
                                pagecolor="#ffffff"
                                bordercolor="#000000"
                                borderopacity="0.25"
                                inkscape:showpageshadow="2"
                                inkscape:pageopacity="0.0"
                                inkscape:pagecheckerboard="0"
                                inkscape:deskcolor="#d1d1d1"
                                inkscape:document-units="mm"
                                showgrid="false"
                                inkscape:zoom="1.5287037"
                                inkscape:cx="334.27014"
                                inkscape:cy="284.88189"
                                inkscape:window-width="1920"
                                inkscape:window-height="1049"
                                inkscape:window-x="1920"
                                inkscape:window-y="0"
                                inkscape:window-maximized="1"
                                inkscape:current-layer="layer1" />
                            <defs
                                id="defs2" />
                            <g
                                inkscape:label="Layer 1"
                                inkscape:groupmode="layer"
                                id="layer1">
                                <path
                                    id="path234"
                                    style="fill:#008d8d;fill-opacity:0;stroke:#000000;stroke-width:2.083;stroke-opacity:0.0121076"
                                    d="M 154.60434,121.71446 A 58.623596,58.623596 0 0 1 95.980741,180.33806 58.623596,58.623596 0 0 1 37.357148,121.71446 58.623596,58.623596 0 0 1 95.980741,63.090865 58.623596,58.623596 0 0 1 154.60434,121.71446 Z" />


                                <text
                                    xml:space="preserve"
                                    style="font-size:15.875px;text-align:center;text-anchor:middle;fill:#000000;fill-opacity:0;stroke:none;stroke-width:2.083;stroke-opacity:0"
                                    id="text1739"
                                    transform="translate(-25.701646,-49.080477)"><textPath
                                        xlink:href="#path234"
                                        startOffset="50%"
                                        id="textPath2569"
                                        style="font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:15.875px;font-family:Vazirmatn;-inkscape-font-specification:Vazirmatn;fill:#000000;fill-opacity:1;stroke:none;stroke-width:2.083;stroke-opacity:0">
                                        {{$slider->dataz[$data->area_name.'_'.$data->part.'_circle']}}
                                    </textPath></text>
                            </g>
                        </svg>
                        <div class="main-content main-dir">
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
            </div>
        @endforeach
    </div>
</section>
