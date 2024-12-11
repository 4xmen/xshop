<section class='GridClips live-setting' data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="{{gfx()['container']}}">
        <div class="grid-video-container">
            @foreach(\App\Models\Clip::where('status',1)->orderByDesc('id')->limit(4)->get() as $clip)
                <div class="grid-clip-item">
                    <i class="ri-file-video-line"></i>
                    <a href="{{$clip->webUrl()}}">
                        <img src="{{$clip->imgUrl()}}" alt="{{$clip->title}}">
                        <h3>
                            {{$clip->title}}
                        </h3>
                    </a>
                    {{--                <img src="{{$clip->imgUrl()}}" alt="">--}}
                </div>
            @endforeach
        </div>
    </div>
</section>
