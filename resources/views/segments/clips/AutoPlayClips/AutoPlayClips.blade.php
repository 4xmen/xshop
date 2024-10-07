<section class='AutoPlayClips'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <div class="autoplay-clip-list">
        @foreach(\App\Models\Clip::where('status',1)->get() as $clip)
            <div class="autoplay-clip-item">
                <a href="{{$clip->webUrl()}}">
                    <video preload="none" src="{{$clip->fileUrl()}}" poster="{{$clip->imgUrl()}}" muted ></video>
                </a>
{{--                <img src="{{$clip->imgUrl()}}" alt="">--}}
            </div>
        @endforeach
        </div>
    </div>
</section>
