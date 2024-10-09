@cache('parallax_footer'. cacheNumber(), 90)
<footer class='ParallaxFooter' style="background-image: url('{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.jpg')}}')">
    <div class="{{gfx()['container']}}">
        <div class="row">

            <div class="col-md-5">
                <h3>
                    {{config('app.name')}}
                </h3>
                <p class="px-4">
                    {{getSetting($data->area_name.'_'.$data->part.'_text')}}
                </p>
            </div>
            <div class="col-md-5">
                <h3>
                    {{getSetting($data->area_name.'_'.$data->part.'_title2')}}
                </h3>
                <ul class="ps-5">
                    @foreach( getGroupPostsBySetting($data->area_name.'_'.$data->part.'_group',5) as $post )
                        <li>
                            <a href="{{$post->webUrl()}}">
                                {{Str::limit($post->title,40)}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-2">
                {!! getSetting($data->area_name.'_'.$data->part.'_last') !!}
            </div>
        </div>
    </div>
    <div class="p2 text-center">
        <ul class="social text-center">
            @foreach(getSettingsGroup('social_')??[] as $k => $social)
                <li class="d-inline-block mx-2">
                    <a href="{{$social}}">
                        <i class="ri-{{$k}}-line"></i>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <p class="text-center">
        {{getSetting('copyright')}}
    </p>
</footer>
@endcache
