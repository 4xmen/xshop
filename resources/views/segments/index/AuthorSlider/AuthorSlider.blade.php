<section class='AuthorSlider'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <div id="slider-author-container">
            <div id="auth-nxt" class="sld-btn">
                <i class="ri-arrow-right-line"></i>
            </div>
            <div id="auth-prv" class="sld-btn">
                <i class="ri-arrow-left-line"></i>
            </div>
            <div id="author-slider">
                @foreach( getGroupPostsBySetting($data->area_name.'_'.$data->part.'_group',10) as $post )
                    <div class="item slider-content">
                        <div class="author-slide">

                            <a href="{{$post->webUrl()}}">
                                <img src="{{$post->orgUrl()}}" class="float-end" alt=" {{$post->title}}" loading="lazy">
                                <div class="contents">

                                    <h3>
                                        {{$post->title}}
                                    </h3>
                                    <p>
                                        {{$post->subtitle}}
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
