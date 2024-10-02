<section id='CounterGrid'>
    <div class="{{gfx()['container']}}">

        <div class="row">
            @for($i = 1; $i <= \Resources\Views\Segments\CounterGrid::$count; $i++)
                <div class="col-lg-3 col-md-6">
                    <i class="{{getSetting($data->area_name.'_'.$data->part.'_icon'.$i)}}"></i>
                    <h3>
                        {{getSetting($data->area_name.'_'.$data->part.'_title'.$i)}}
                    </h3>
                    <div class="grid-counter" data-min="0" data-max="{{getSetting($data->area_name.'_'.$data->part.'_number'.$i)}}">
                        0
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
