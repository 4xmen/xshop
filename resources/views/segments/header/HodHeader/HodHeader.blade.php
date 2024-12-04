<section class='HodHeader live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <div class="row">
            <div class="col-md">
                <h1>
                    {{$title}}
                </h1>
                <h2>
                    {{$subtitle}}
                </h2>
            </div>
            <div class="col-md-3 text-end">
                <div id="hod-logo">
                <img src="{{asset('upload/images/logo.png')}}" alt="logo" >
                </div>
            </div>
        </div>
    </div>
</section>
