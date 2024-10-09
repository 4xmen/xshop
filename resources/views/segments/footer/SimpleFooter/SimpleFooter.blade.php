@cache('simple_footer'. cacheNumber(), 90)
<section class='SimpleFooter'>
    <div class="content">
        <div class="{{gfx()['container']}}">
            <div class="row">
                <div class="col-md-4">

                    <h3>
                        {{getSetting($data->area_name.'_'.$data->part.'_title1')}}
                    </h3>
                    <ul>
                    @foreach( getGroupPostsBySetting($data->area_name.'_'.$data->part.'_group1',5) as $post )
                        <li>
                            <a href="{{$post->webUrl()}}">
                                {{Str::limit($post->title,40)}}
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </div>
                <div class="col-md-4">
                    <h3>
                        {{getSetting($data->area_name.'_'.$data->part.'_title2')}}
                    </h3>
                    <ul>
                        @foreach( getGroupPostsBySetting($data->area_name.'_'.$data->part.'_group2',5) as $post )
                            <li>
                                <a href="{{$post->webUrl()}}">
                                    {{Str::limit($post->title,40)}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-4">
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
    </div>
</section>
@endcache
