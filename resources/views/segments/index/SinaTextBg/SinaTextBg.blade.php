<section class="SinaTextBg live-setting" data-live="{{$data->area_name.'_'.$data->part}}" style="background-image: url('{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.jpg')}}')">
    <div class="container">
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
                <div class="sina-box">
                    <div class="txt">
                        {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
                    </div>
                    <a class="btn btn-outline-dark" href="{{getSetting($data->area_name.'_'.$data->part.'_link')}}">
                        {{getSetting($data->area_name.'_'.$data->part.'_btn')}}
                    </a>
                </div>
            </div>
            <div class="col-md-3">

            </div>
        </div>
    </div>
</section>
