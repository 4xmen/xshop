<section class='GradientTextLink py-4' style="--deg: {{getSetting($data->area->name.'_'.$data->part.'_deg')}}deg">
    <div class="{{gfx()['container']}} py-4 text-center">
        <h1>
            {{getSetting($data->area->name.'_'.$data->part.'_title')}}
        </h1>
        <a class="btn btn-outline-invert" href="{{getSetting($data->area->name.'_'.$data->part.'_link')}}">
            {{getSetting($data->area->name.'_'.$data->part.'_btn')}}
        </a>
    </div>
</section>
