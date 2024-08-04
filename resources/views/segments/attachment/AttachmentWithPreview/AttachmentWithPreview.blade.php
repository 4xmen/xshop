<section class='AttachmentWithPreview'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{$attachment->title}}
        </h1>
        <div class="alert alert-info">
            {{$attachment->subtitle}}
        </div>
        {!! $attachment->body !!}

        @if($attachment->ext == 'mp3')
            <mp3player
                asset="{{$attachment->url()}}"></mp3player>
        @endif
        @if($attachment->ext == 'mp4')
            <mp4player
                asset="{{$attachment->url()}}"></mp4player>
        @endif


        <a href="{{$attachment->tempUrl()}}" class="btn btn-lg btn-outline-primary mt-4 w-100">
            <i class="ri-download-2-line"></i>
            &nbsp;
            {{__("Download")}}

            {{formatFileSize($attachment->size)}}

            &nbsp;
            [{{$attachment->ext}}]
        </a>
    </div>
</section>
