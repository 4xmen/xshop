<section id='InlineMap'>
    <div id="mapContainer" @if(getSetting($data->area->name.'_'.$data->part.'_dark')) class="dark-mode" @endif>

    </div>
    @php($mapData = explode(',',getSetting($data->area->name.'_'.$data->part.'_loc')))
    <input type="hidden" id="maplat" value="{{$mapData[0]}}">
    <input type="hidden" id="maplng" value="{{$mapData[1]}}">
    <input type="hidden" id="mapzoom" value="{{$mapData[2]}}">
</section>
