<section id='CurvePosts' class=' live-setting' data-live="{{$data->area_name.'_'.$data->part}}">


    <div id="curve-post-top">

    </div>
    <div>

        <h1 class="text-center">
            {{getSetting($part->area_name . '_' . $part->part.'_title')}}
        </h1>
        <div id="curve-slider-post-container">

            <a href="{{getGroupBySetting($part->area_name . '_' . $part->part.'_group')->webUrl()}}" id="curve-all-posts" data-bs-custom-class="custom-tooltip"
               data-bs-toggle="tooltip" data-bs-placement="auto"
               title="{{__("Find more")}}">
                <i class="ri-folder-open-line"></i>
            </a>

            <div id="crp-nxt" class="sld-btn">
                <i class="ri-arrow-right-line"></i>
            </div>
            <div id="crp-prv" class="sld-btn">
                <i class="ri-arrow-left-line"></i>
            </div>

            <div id="curve-slider-post">
                @foreach(getGroupPostsBySetting($part->area_name . '_' . $part->part.'_group',12) as $post)
                    <div class="item slider-content">
                        <div class="curve-post-item">
                            <a href="{{$post->webUrl()}}">
                                <img src="{{$post->imgUrl()}}" alt="{{$post->title}}">
                                <h4>
                                    {{$post->title}}
                                </h4>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="curve-post-bottom">

    </div>
</section>
