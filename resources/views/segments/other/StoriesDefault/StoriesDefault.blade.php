<section class="StoriesDefault live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <ul class="story-default-list">
            @foreach(\App\Models\Story::where('status','1')->orderBy('sort')->get() as $k => $story)
                <li class="story-default-item" data-title="{{$story->title}}"
                    data-desc="{{$story->description}}" data-like-count="{{$story->likes}}"
                    data-comment-count="{{$story->commentCount()}}" data-file="{{$story->url()}}">
                    <img src="{{$story->imgUrl()}}" alt="{{$story->title}}">
                </li>
            @endforeach
        </ul>

        <div id="story-modal">
            <div class="modal-content">
                <ul class="slides">
                    @foreach(\App\Models\Story::where('status','1')->orderBy('sort')->get() as $k => $story)
                        <li class="slide">
                            @if($story->ext == 'mp4')
                                <video src="{{$story->url()}}"></video>
                            @else
                                <img src="{{$story->url()}}">
                            @endif
                            <div class="story-footer">
                                <h3>
                                    {{$story->title}}
                                </h3>
                                <p>
                                    {{$story->description}}
                                </p>
                                <span class="like">
                                {{$story->likes}}
                            </span>
                                <span class="comment">
                                {{$story->commentCount()}}
                            </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
