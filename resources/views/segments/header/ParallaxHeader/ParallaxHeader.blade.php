<header class='ParallaxHeader live-setting' data-live="{{$data->area_name.'_'.$data->part}}" style="background-image: url('{{$bg??asset('upload/images/'.$part->area_name . '.' . $part->part.'.jpg')}}')">
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <h2>
            &nbsp;
            {{$subtitle}}
        </h2>
    </div>
</header>
