<div class="simple-single-comment">
    <div class="row">
        <div class="col-3">
            @if($comment->commentator()['url'] == null)
                <span class="tag float-end">
                        {{__("Guest")}}
                    </span>
                {{$comment->commentator()['name']}}
            @else
                @if($comment->commentator_type == \App\Models\User::class)
                    <span class="tag float-end">
                        {{__("Admin")}}
                    </span>
                @else
                    <span class="tag float-end">
                        {{__("Customer")}}
                    </span>
                @endif
                {{$comment->commentator()['name']}}
            @endif
        </div>
        <div class="col-9">
            <button type="button" class="btn btn-primary btn-sm float-end comment-reply" data-id="{{$comment->id}}">
                <i class="ri-reply-line"></i>
            </button>
            <p class="pe-4">
                {{$comment->body}}
            </p>
        </div>
    </div>
    @if($comment->children->count() > 0)
        @foreach($comment->children as $comment)
            @include('segments.post.SimplePost.inc.comment-detail',$comment)
        @endforeach
    @endif
</div>
