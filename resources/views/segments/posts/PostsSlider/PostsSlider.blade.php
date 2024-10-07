<section class='PostsSlider'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>

    </div>
    <div id="posts-slider-container">

        <div id="posts-slider">

            @foreach( getGroupPostsBySetting($data->area_name.'_'.$data->part.'_group',10) as $post )
                <div class="item slider-content">
                    <div class="post-slider">

                        <a href="{{$post->webUrl()}}">
                            <img src="{{$post->orgUrl()}}" alt=" {{$post->title}}" loading="lazy">
                            <h3>
                                {{$post->title}}
                            </h3>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
