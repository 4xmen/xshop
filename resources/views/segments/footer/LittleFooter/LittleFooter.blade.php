<section class='LittleFooter'>
    <div class="{{gfx()['container']}}">
        <div class="row">
            <div class="col-md-4">
                {{getSetting('copyright')}}
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
                {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
            </div>
        </div>
    </div>
</section>
