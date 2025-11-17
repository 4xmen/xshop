<footer class="BabaFooter live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <hr>
        <div class="row">
            <div class="col-lg-6">
                <div class="row baba-list pt-4">
                    @foreach(range(1,3) as $i)
                        <div class="col-md">
                            <h3 class="toggle">
                                {{getSetting($data->area_name.'_'.$data->part.'_title'.$i)}}
                            </h3>
                            <ul class="content">
                                @foreach( getGroupPostsBySetting($data->area_name.'_'.$data->part.'_group'.$i,10) as $post )
                                    <li>
                                        <a href="{{$post->webUrl()}}">
                                            {{Str::limit($post->title,15)}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="col-lg-6 text-end">
                <img src="{{asset('assets/upload/logo.svg')}}" class="logo" alt="[logo]">
                <br>
                {{__("Contact us")}}:
                <a href="tel:{{getSetting('tel')}}">
                    {{getSetting('tel')}}
                </a>
                <div class="images">
                    {!! getSetting($data->area_name.'_'.$data->part.'_images') !!}
                </div>
            </div>

        </div>
        <div class="p-2 text-muted">
            {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
        </div>
        <hr>
        <div class="row">
            <div class="col-md py-3">
                {{getSetting('copyright')}}
            </div>
            <div class="col-md">
                <div class="col-md text-end">
                    <ul class="social">
                        @foreach(getSettingsGroup('social_')??[] as $k => $social)
                            <li class="d-inline-block mx-2">
                                <a href="{{$social}}">
                                    <i class="ri-{{$k}}-line"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</footer>
