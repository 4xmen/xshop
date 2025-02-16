<section class="GroupDescription live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="{{gfx()['container']}} py-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1>
                    {{$group->name}}
                </h1>
                {{$group->description}}
            </div>
            <div class="col-md-6">
                <img src="{{$group->imgUrl()}}" alt="{{$group->name}}" class="img-fluid">
            </div>
        </div>
    </div>
</section>
