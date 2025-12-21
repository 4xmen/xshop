@foreach($posts as $post)
    <div class="col-md-4">
        <div class="grid-post-item">
            <div class="corner">
                {{$post->mainGroup->name}}
            </div>
            <a href="{{$post->webUrl()}}">
                <img src="{{$post->imgUrl()}}" alt="{{$post->title}}" loading="lazy">
                <h4>
                    {{$post->title}}
                </h4>
            </a>
            <div class="text-muted py-2">
                                    <span>
                                        <i class="ri-calendar-line"></i>
                                        {{$post->created_at->ldate('Y/m/d l')}}
                                    </span>
                <span class="float-end">
                                        <i class="ri-eye-line"></i>
                                        {{number_format($post->view)}}
                                    </span>
            </div>
            <p>
                {{$post->subtitle}}
                <br>
            </p>
            <a href="{{$post->webUrl()}}" class="btn btn-outline-primary my-2 btn-sm">
                {{__("Read more")}}
            </a>
        </div>
    </div>
@endforeach
