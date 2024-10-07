<section class='GalleriesList'>

    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <div class="row">
            @foreach($galleries as $gallery)
                <div class="col-md-6 p-1">
                    <div class="gallrey-item">
                        <a href="{{$gallery->webUrl()}}">
                            <img src="{{$gallery->imgUrl()}}" alt="{{$gallery->title}}" loading="lazy">
                        </a>
                        <h4 class="text-center">
                            {{$gallery->title}}
                        </h4>
                    </div>
                </div>
            @endforeach
        </div>
        {{$galleries->links()}}
    </div>
</section>
