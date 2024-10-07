<section class='DorClip content'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <div id="video-preview-botz">
            <video controls src="{{$clip->fileUrl()}}" poster="{{$clip->imgUrl()}}" preload="none"></video>
        </div>
        <mp4player
            asset="{{$clip->fileUrl()}}" cover="{{$clip->imgUrl()}}"></mp4player>
        <div class="text-muted clip-body ps-4 border-end-0 mt-4">
            {!! $clip->body !!}
        </div>
    </div>
</section>
