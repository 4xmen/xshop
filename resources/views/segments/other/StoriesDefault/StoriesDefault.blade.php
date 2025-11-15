<section class="StoriesDefault live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">

        <a href="{{getSetting($data->area_name.'_'.$data->part.'_link')}}" class="mb-2">
            <h6>
                {{getSetting($data->area_name.'_'.$data->part.'_title')}}
            </h6>
        </a>
        <input type="hidden" id="like-url" value="{{route('client.story-like')}}">
        <input type="hidden" id="def-story-timeout" value="{{getSetting($data->area_name.'_'.$data->part.'_timeout')}}">
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
                                <img src="{{$story->url()}}" alt="{{$story->title}}">
                            @endif
                            <div class="story-footer">
                                <h3>
                                    {{$story->title}}
                                </h3>
                                <p>
                                    {{$story->description}}
                                </p>
                                <span class="like" data-id="{{$story->id}}">
                                    <b>
                                        {{$story->likes}}
                                    </b>
                                    <i class="ri-heart-line"></i>
                                </span>
{{--                                <span class="comment">--}}
{{--                                    {{$story->commentCount()}}--}}
{{--                                </span>--}}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
