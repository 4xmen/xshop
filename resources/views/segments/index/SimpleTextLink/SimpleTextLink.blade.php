<section class='SimpleTextLink py-4'>
    <div class="{{gfx()['container']}} py-4 text-center">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <a class="btn btn-outline-invert" href="{{getSetting($data->area_name.'_'.$data->part.'_link')}}">
            {{getSetting($data->area_name.'_'.$data->part.'_btn')}}
        </a>
    </div>
</section>
