<section class="ImageContent live-setting" data-live="{{$data->area_name.'_'.$data->part}}" style="background-image: url('{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.jpg')}}')" >

    <div class="{{gfx()['container']}} justify-content-center d-flex align-items-end">
        <div class="text-center">
            <h1>
                {{getSetting($data->area_name.'_'.$data->part.'_title')}}
            </h1>
            {!! getSetting($data->area_name.'_'.$data->part.'_subtitle') !!}
            <a href="{{getSetting($data->area_name.'_'.$data->part.'_link')}}" class="btn btn-primary">
                {{getSetting($data->area_name.'_'.$data->part.'_btn')}}
            </a>
        </div>
    </div>
</section>
