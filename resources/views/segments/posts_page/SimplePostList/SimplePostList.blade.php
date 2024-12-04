<section class='SimplePostList content live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        @if(\App\Models\Post::where('status',1)->where('is_pinned',1)->count() < 0 )
        <div class="row pinned-posts">
            @foreach(\App\Models\Post::where('status',1)->where('is_pinned',1)->limit(2)->get() as $post)
                <div class="col-md-6 p-1">
                    <div class="post-item">
                        <div class="corner">
                            {{$post->mainGroup->name}}
                        </div>
                        <a href="{{$post->webUrl()}}">
                            <img src="{{$post->orgUrl()}}" alt="{{$post->title}}"
                                 title="{{implode(',',$post->tags->pluck('name')->toArray()??'')}}" loading="lazy">
                        </a>
                        <div class="detail">
                            <h4>
                                {{$post->title}}
                            </h4>
                            <span>
                                {{$post->created_at->ldate('Y/m/d l')}}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        @endif
        @foreach($posts as $post)
            <div class="post-list-item">
                <img src="{{$post->imgUrl()}}" class="float-start me-4" alt="{{$post->title}}" loading="lazy">
                <h4>
                    {{$post->title}}
                </h4>
                <div class="text-muted py-2">
                    {{$post->created_at->ldate('Y/m/d l')}}
                </div>
                <p>
                    {{$post->subtitle}}
                    <br>
                    <a href="{{$post->webUrl()}}" class="btn btn-outline-primary my-2 btn-sm">
                        {{__("Read more")}}
                    </a>
                </p>
            </div>
        @endforeach
        {{$posts->links()}}
    </div>
</section>
