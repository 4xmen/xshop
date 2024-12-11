<section class='CurveFooter live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="curve-footer-top">
    </div>
    <div class="{{gfx()['container']}} wrapper">
        <div class="row">
            <div class="col-md-4">
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
            <div class="col-md-4 text-center">
                <img src="{{asset('upload/images/logo.png')}}" class="logo" alt="">
            </div>
            <div class="col-md-4 pt-2">
                {!! getSetting($data->area_name.'_'.$data->part.'_text')!!}
            </div>
        </div>
    </div>


    <div class="copyright">
        <div class="{{gfx()['container']}} py-3 text-center">
            {{getSetting('copyright')}}
        </div>
    </div>
</section>
