<section id='CurveCategories' class=' live-setting' data-live="{{$data->area_name.'_'.$data->part}}">


    <div id="curve-cat-top">

    </div>
    <div>
        {{--        class="{{gfx()['container']}}"--}}

        <h1 class="text-center">
            {{getSetting($part->area_name . '_' . $part->part.'_title')}}
        </h1>
        <div id="curve-slider-cat-container">

            <div id="crc-nxt" class="sld-btn">
                <i class="ri-arrow-right-line"></i>
            </div>
            <div id="crc-prv" class="sld-btn">
                <i class="ri-arrow-left-line"></i>
            </div>

            <div id="curve-slider-cat">
                @foreach(getCategorySubCatsBySetting($part->area_name . '_' . $part->part.'_category') as $cat)
                    <div class="item slider-content">
                        <div class="curve-cat-item">
                            <a href="{{$cat->webUrl()}}">
                                <img src="{{$cat->imgUrl()}}" alt="{{$cat->name}}">
                                <h4>
                                    {{$cat->name}}
                                </h4>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="curve-cat-bottom">

    </div>
</section>
