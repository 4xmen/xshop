<section class="AutoPlayAttachment live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <div class="{{gfx()['container']}}">
        <h1>
            {{getSetting($data->area_name.'_'.$data->part.'_title')}}
        </h1>
        <div class="autoplay-clip-list">
            @php($group = \App\Models\Group::first())
            @foreach($group->attachs()->where('ext','mp4')->get() as $clip)
                <div class="autoplay-clip-item-group">
                    <a href="{{$clip->url()}}">
                        <i class="ri-play-circle-line"></i>
                        <video preload="none" src="{{$clip->url()}}" poster="{{$group->bgUrl()}}" muted ></video>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
