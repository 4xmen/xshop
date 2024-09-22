<section class='SimpleComments'>
    <div class="{{gfx()['container']}}">
        <h5>
            {{__("Comments")}}
        </h5>
        @foreach($data['comments']??[] as $comment)
            @include('segments.post.SimplePost.inc.comment-detail',$comment)
        @endforeach
        <h5>
            {{__("Post your comment")}}
        </h5>
        @include('components.err')
        <form  id="comment-form" class="safe-form" method="post">
            <div class="safe-url" data-url="{{route('client.comment.submit')}}"></div>
            @csrf

            <input type="hidden" name="commentable_type" value="{{$data['commentable_type']}}">
            <input type="hidden" name="commentable_id" value="{{$data['commentable_id']}}">
            <input type="hidden" name="parent_id" id="parent_id" >
            <div class="row">

                @if(auth()->check())
                    <div class="col-12">
                    <span class="comment-as">
                        {{auth()->user()->name}}
                    </span>
                    </div>
                @elseif(auth('customer')->check())
                    <div class="col-12">
                    <span class="comment-as">
                        {{auth('customer')->user()->name}}
                    </span>
                    </div>
                @else
                    <div class="col-md-6">
                        <label for="name">
                            {{__("Name")}}
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="{{__("Name")}}" id="name">
                    </div>
                    <div class="col-md-6">
                        <label for="name">
                            {{__("Email")}}
                        </label>
                        <input type="email" name="email" class="form-control" placeholder="{{__("Email")}}" id="email">
                    </div>
                @endif
                <div class="col-12 mt-2">
                    <label>
                        {{__("Message")}}
                    </label>
                    <textarea name="message" placeholder="{{__("Message...")}}" class="form-control"
                              rows="3"></textarea>
                    <div class="text-center">

                        <button class="btn btn-primary w-25 my-3  ">
                            <i class="ri-send-plane-2-line"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>
