<section id='InlineMap'>
    <div class="{{gfx()['container']}}">
        <h5>
            <a href="{{getSetting($data->area_name.'_'.$data->part.'_link')}}">
                {{getSetting($data->area_name.'_'.$data->part.'_title')}}
            </a>
        </h5>
    </div>
    <div id="mapContainer" @if(getSetting($data->area_name.'_'.$data->part.'_dark')) class="dark-mode" @endif>

    </div>
    @php($mapData = explode(',',getSetting($data->area_name.'_'.$data->part.'_loc')))
    <input type="hidden" id="maplat" value="{{$mapData[0]}}">
    <input type="hidden" id="maplng" value="{{$mapData[1]}}">
    <input type="hidden" id="mapzoom" value="{{$mapData[2]}}">
</section>
