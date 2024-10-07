<section class='GridGallery'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{ getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <div class="row">
            @foreach(\App\Models\Gallery::where('status',1)->orderBy('id')->limit( getSetting($data->area_name.'_'.$data->part.'_limit'))->get() as $gallery)
                <div class="col-md p-1">
                    <a class="gallery-grid" href="{{$gallery->webUrl()}}">

                        <img src="{{$gallery->imgUrl()}}" alt="{{$gallery->title}}" loading="lazy">
                        <h4>
                            <span>
                                {{$gallery->title}}
                            </span>
                        </h4>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
