<section class='ParallaxShort' style="background-image: url('{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.jpg')}}')">
    <div class="{{gfx()['container']}} pt-5">
        <h1 class="pt-5">
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <h2>
            {{getSetting($data->area_name.'_'.$data->part.'_subtitle')}}
        </h2>
    </div>
</section>
