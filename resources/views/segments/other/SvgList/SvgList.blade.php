<section class="SvgList live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="{{gfx()['container']}}">
        <div class="row pt-4">
            @for($i = 1 ; $i <= 4; $i++)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{getSetting($data->area_name.'_'.$data->part.'_link'.$i)}}">
                    <img src="{{asset('upload/images/'.$data->area_name.'.'.$data->part. $i.'.svg')}}" alt="">
                    <h3>
                        {{getSetting($data->area_name.'_'.$data->part.'_title'.$i)}}
                    </h3>
                    </a>
                </div>
            @endfor
        </div>
    </div>
</section>
