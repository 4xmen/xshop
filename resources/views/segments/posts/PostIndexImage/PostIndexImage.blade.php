<section class='PostIndexImage'>
    <div class="{{gfx()['container']}}">
        <h1>
            <a href="{{getGroupBySetting($data->area_name.'_'.$data->part.'_group')?->webUrl()}}">
                {{getGroupBySetting($data->area_name.'_'.$data->part.'_group')?->name}}
            </a>
        </h1>
        <p class="text-muted">
            {{getGroupBySetting($data->area_name.'_'.$data->part.'_group')?->description}}
        </p>
        <div class="row">
            @foreach( getGroupPostsBySetting($data->area_name.'_'.$data->part.'_group',4) as $post )
                <div class="col-lg-3 col-md-6">
                    <div class="post-img-index">
                        <img src="{{$post->imgUrl()}}" alt="{{$post->title}}" class="img-fluid" loading="lazy">
                        <h3>
                            {{$post->title}}
                        </h3>
                        <p class="text-muted">
                            {{$post->subtitle}}
                        </p>
                        <a href="{{$post->webUrl()}}">
                            {{__("Read more")}}
                        </a>
                    </div>
                </div>

            @endforeach
        </div>
        <div class="py-5 text-center">
            <a href="{{getGroupBySetting($data->area_name.'_'.$data->part.'_group')?->webUrl()}}" class="btn btn-outline-primary">
                {{getSetting($data->area_name.'_'.$data->part.'_btn')}}
            </a>
        </div>
    </div>
</section>
