<section class='PostsIconSimple py-4'>
    <div class="{{gfx()['container']}}">
        <h1>
            <a href="{{getGroupBySetting($data->area_name.'_'.$data->part)?->webUrl()}}">
                {{getGroupBySetting($data->area_name.'_'.$data->part)?->name}}
            </a>
        </h1>
        <p>
           {{getGroupBySetting($data->area_name.'_'.$data->part)?->description}}
        </p>
        <div class="row">
            @foreach(getGroupPostsBySetting($data->area_name.'_'.$data->part, getSetting($data->area_name.'_'.$data->part.'_limit')) as $post)
            <div class="col-md-4">
                <i class="{{$post->icon}}"></i>
                <h3>
                    {{$post->title}}
                </h3>

                <p>
                   {{$post->subtitle}}
                </p>

                <a href="{{$post?->webUrl()}}" class="btn btn-outline-primary w-100">
                    {{__("Read more")}}
                </a>
            </div>
            @endforeach

        </div>
    </div>
</section>
