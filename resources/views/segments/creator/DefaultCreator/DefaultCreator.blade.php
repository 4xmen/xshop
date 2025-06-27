<section class="DefaultCreator live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="{{gfx()['container']}}">
        <div class="row">
            <div class="col-md-4 pt-2">
                <img src="{{$creator->imgUrl()}}" class="img-fluid" alt="{{$creator->name}}">
            </div>
            <div class="col-md-8 pt-3">
                <h1>
                    {{$creator->name}}
                </h1>
                <h2>
                    {{$creator->subtitle}}
                </h2>
                <p>
                    {{$creator->description}}
                </p>
            </div>
        </div>
    </div>
</section>
