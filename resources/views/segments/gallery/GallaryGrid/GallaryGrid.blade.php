<section class='GallaryGrid'>
    <div class="{{gfx()['container']}}">
        <div class="row py-4">
            @if($gallery->images->count() > 0)
                @foreach($gallery->images as $image)
                    <div class="col-lg-3 col-md-6 mb-4">
                        <a class="gallery-image light-box" data-toggle="lightbox" data-gallery="{{$gallery->slug}}" href="{{$image->imgOriginalUrl()}}">
                            <img src="{{$image->imgurl()}}" class="img-fluid" alt="{{$image->title}}" title="{{$image->title}}" loading="lazy">
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
