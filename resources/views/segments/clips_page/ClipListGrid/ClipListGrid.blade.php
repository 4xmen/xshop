<section class='ClipListGrid content'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <div class="row">
            @foreach($clips as $clip)

                <div class="col-lg-4">

                    <div class="clip-grid-item">
                        <a href="{{$clip->webUrl()}}">
                            <img src="{{$clip->imgUrl()}}" alt="" loading="lazy">
                            <h2>
                                <span>
                                    {{$clip->title}}
                                </span>
                                <i class="ri-play-circle-line"></i>
                            </h2>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
