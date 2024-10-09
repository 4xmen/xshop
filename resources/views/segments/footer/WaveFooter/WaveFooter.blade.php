@cache('wave_footer'. cacheNumber(), 90)
<footer class='WaveFooter'
        style="--speed: {{getSetting($data->area_name.'_'.$data->part.'_speed')}}s;
        --speed2: {{getSetting($data->area_name.'_'.$data->part.'_speed2')}}s;
        --speed3: {{getSetting($data->area_name.'_'.$data->part.'_speed3')}}s">
    <svg
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28"
        preserveAspectRatio="none"
    >
        <defs>
            <path
                id="gentle-wave"
                d="M-160 44c30 0
        58-18 88-18s
        58 18 88 18
        58-18 88-18
        58 18 88 18
        v44h-352z"
            />
        </defs>
        <g class="waves">
            <use
                xlink:href="#gentle-wave"
                x="50"
                y="0"
                fill-opacity=".2"
            />
            <use
                xlink:href="#gentle-wave"
                x="50"
                y="3"
                fill-opacity=".5"
            />
            <use
                xlink:href="#gentle-wave"
                x="50"
                y="6"
                fill-opacity=".9"
            />
        </g>
    </svg>
    <div class="content">
        <div class="{{gfx()['container']}}">
            {{getSetting('copyright')}}        </div>
    </div>
</footer>
@endcache
