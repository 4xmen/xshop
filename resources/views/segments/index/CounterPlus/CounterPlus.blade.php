<section class="CounterPlus live-setting" id="CounterPlus" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">

        <div class="row">
            @for($i = 1; $i <= \Resources\Views\Segments\CounterPlus::$count; $i++)
                <div class="col-lg-3 col-md-6 ">

                    <div class="cplus-item">

                        <i class="{{getSetting($data->area_name.'_'.$data->part.'_icon'.$i)}} me-3"></i>
                        <div class="plus-counter" data-min="0"
                             data-max="{{getSetting($data->area_name.'_'.$data->part.'_number'.$i)}}">
                            0
                        </div>
                        <a href="{{getSetting($data->area_name.'_'.$data->part.'_link'.$i)}}">
                            <h3>
                                {{getSetting($data->area_name.'_'.$data->part.'_title'.$i)}}
                            </h3>
                        </a>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
