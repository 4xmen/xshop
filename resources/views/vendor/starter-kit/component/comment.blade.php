<li>
    <div class="comment-main-level">
        <!-- Avatar -->
        <div class="comment-avatar"><img src="https://www.gravatar.com/avatar/{{md5($c->email)}}?s=64"></div>
        <!-- Contenedor del Comentario -->
        <div class="comment-box">
            <div class="comment-head">
                <h6 class="comment-name">
                    <a href="#">
                        {{$c->name}}
                    </a>
                </h6>
                <span>{{$c->persianDate()}}</span>
                <i class="fa fa-reply  comment-reply" data-id="{{$c->id}}" title="{{__("reply")}}"></i>
                <i class="fa fa-heart"></i>
            </div>
            <div class="comment-content">
                {{$c->body}}
            </div>
        </div>
    </div>
    @if ($c->approved_children()->count()>0)
        <ul class="comments-list reply-list">

            @foreach($c->approved_children as $cch)
                <li>
                    @include('starter-kit::component.comment', ['c' => $cch])
                </li>
            @endforeach
        </ul>
    @endif
</li>
