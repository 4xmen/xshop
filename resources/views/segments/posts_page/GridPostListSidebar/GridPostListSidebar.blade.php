<section class='GridPostListSidebar content'>
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
                                {{$post->created_at->ldate('Y-m-d l')}}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <hr>
        @endif
        <div class="row">
            @if(!getSetting($data->area_name.'_'.$data->part.'_invert'))
                <div class="col-lg-3 p-0">
                    @include('segments.posts_page.GridPostListSidebar.inc.sidebar')
                </div>
            @endif
            <div class="col-lg-9">
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-4">
                            <div class="grid-post-item">
                                <div class="corner">
                                    {{$post->mainGroup->name}}
                                </div>
                                <img src="{{$post->imgUrl()}}" alt="{{$post->title}}" loading="lazy">
                                <h4>
                                    {{$post->title}}
                                </h4>
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
                </div>
                {{$posts->links()}}
            </div>
                @if(getSetting($data->area_name.'_'.$data->part.'_invert'))
                    <div class="col-lg-3 p-0">
                        @include('segments.posts_page.GridPostListSidebar.inc.sidebar')
                    </div>
                @endif
        </div>
    </div>
</section>
