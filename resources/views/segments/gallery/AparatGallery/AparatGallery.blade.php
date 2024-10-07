<section id='AparatGallery'>
    {{--    <div class="{{gfx()['container']}}">--}}
    <img src="{{$gallery->images[0]->imgOriginalUrl()}}" id="aparat-main-image" alt="">
    <div class="aparat-list">
        @if($gallery->images->count() > 0)
            @foreach($gallery->images as $image)
                <div class="aparat-item">
                    <a class="gallery-image aparat-link"
                       href="{{$image->imgOriginalUrl()}}">
                        <img src="{{$image->imgurl()}}" class="img-fluid" alt="{{$image->title}}" title="{{$image->title}}" loading="lazy">
                    </a>
                </div>
            @endforeach
        @endif
    </div>
    {{--    </div>--}}
</section>
