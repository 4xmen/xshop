<section class="TimerEvent live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="{{gfx()['container']}}">

        <div class="contents">
            <h4 class="my-3 text-center">
                {{getSetting($data->area_name.'_'.$data->part.'_title')}}
            </h4>
            <div class="row p-0">
                <div class="col-md-4">
                    <img src="{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.jpg')}}" alt="next marasem"
                         class="img-fluid">
                </div>
                <div class="col-md-8">
                    <div id="countdown">
                        <div id="dcd" data-text="{{__("Day(s)")}}">0</div>
                        <div id="hcd" data-text="{{__("Hour(s)")}}">0</div>
                        <div id="mcd" data-text="{{__("Minute(s)")}}">0</div>
                        <div id="scd" data-text="{{__("Second(s)")}}">0</div>
                    </div>
                    <div class="pe-5">
                        {!! getSetting($data->area_name.'_'.$data->part.'_last') !!}
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="count-down-time-timestamp" value="{{ getSetting($data->area_name.'_'.$data->part.'_date')}}">
    </div>
</section>
