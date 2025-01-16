<section class="TimerUnderConstruction live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="container">
        <h1>
            {{$title}}
        </h1>
        <h2>
            {{getSetting('desc')}}
        </h2>
        <img src="{{asset('assets/default/under-construction.svg')}}" alt="under-construction">
        <div id="under-countdown">
            <div id="udcd" data-text="{{__("Day(s)")}}">0</div>
            <div id="uhcd" data-text="{{__("Hour(s)")}}">0</div>
            <div id="umcd" data-text="{{__("Minute(s)")}}">0</div>
            <div id="uscd" data-text="{{__("Second(s)")}}">0</div>
        </div>
        <div class="my-3">
            {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
        </div>
        <ul class="social-list">
            @foreach(getSettingsGroup('social_')??[] as $k => $social)
                <li>
                    <a href="{{$social}}">
                        <i class="ri-{{$k}}-line"></i>
                    </a>
                </li>
            @endforeach
            <li>
                <a href="tel:{{getSetting('tel')}}">
                    <i class="ri-phone-line"></i>
                </a>
            </li>
            <li>
                <a href="mailto:{{getSetting('email')}}">
                    <i class="ri-mail-line"></i>
                </a>
            </li>
        </ul>
    </div>
    <input type="hidden" id="under-count-down-time-timestamp" value="{{ getSetting($data->area_name.'_'.$data->part.'_date')}}">

</section>
