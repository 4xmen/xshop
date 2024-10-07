<section class='PostSidebar content'>
    <div class="{{gfx()['container']}}">
        <dov class="row">
            @if(!getSetting($data->area_name.'_'.$data->part.'_invert'))
            <div class="col-lg-3 p-0">
                @include('segments.post.PostSidebar.inc.sidebar')
            </div>
            @endif
            <div class="col-lg-9 p-0">
                <div class="py-2 px-4">
                    <span class="float-end text-muted">
                        {{__("Time spend")}}: {{$post->spendTime()}}
                    </span>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{homeUrl()}}">
                                    {{config('app.name')}}
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{$post->mainGroup->webUrl()}}">
                                    {{$post->mainGroup->name}}
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{$post->title}}
                            </li>
                        </ol>
                    </nav>
                    <img src="{{$post->orgUrl()}}" alt="" class="img-fluid" loading="lazy">
                    <p class="text-muted my-3">
                        {{$post->subtitle}}
                    </p>
                    <div class="row text-center">
                        <div class="col-md">
                            <i class="ri-calendar-line"></i>
                            {{$post->created_at->ldate('Y/m/d H:i')}}
                        </div>
                        <div class="col-md">
                            <i class="ri-message-line"></i>
                            {{number_format($post->approvedComments()->count())}}
                        </div>
                        <div class="col-md">
                            <i class="ri-eye-line"></i>
                            {{number_format($post->view)}}
                        </div>
                        @if($post->tags()->count() > 0)
                            <div class="col-md-6">
                                {{__("Tags")}}:
                                @foreach($post->tags as $tag)
                                    <a href="{{tagUrl($tag->slug)}}" class="tag me-2">
                                        <i class="ri-price-tag-line"></i>
                                        {{$tag->name}}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <hr>
                    @if($post->table_of_contents)
                        {!! $post->tableOfContents() !!}
                        {!! $post->bodyContent() !!}
                    @else

                        {!! $post->body !!}
                    @endif

                </div>

            </div>
            @if(getSetting($data->area_name.'_'.$data->part.'_invert'))
                <div class="col-lg-3 p-0">
                    @include('segments.post.PostSidebar.inc.sidebar')
                </div>
            @endif
        </dov>
    </div>
</section>
