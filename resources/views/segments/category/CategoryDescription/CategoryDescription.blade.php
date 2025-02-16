<section class="CategoryDescription live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
        <div class="{{gfx()['container']}} py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>
                        {{$category->name}}
                    </h1>
                    {{$category->description}}
                </div>
                <div class="col-md-6">
                    <img src=" {{$category->imgUrl()}}" alt="{{$category->name}}" class="img-fluid">
                </div>
            </div>
        </div>

</section>
