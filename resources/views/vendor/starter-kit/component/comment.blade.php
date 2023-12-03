<li>
    <div class="row">
        <div class="col-md-3 text-center">
            <img class="img-avatar"  src="https://www.gravatar.com/avatar/{{md5($c->email)}}?s=64" alt="avatar" />
            {{$c->name}}
            <br>
            {{$c->persianDate()}}
            <br>
            <span class="btn-sm btn-secondary comment-reply" data-id="{{$c->id}}" title="{{__("reply")}}">
                <i class="fa fa-reply"></i>
            </span>
        </div>
        <div class="col-md-9">
            <p>
                {{$c->body}}
            </p>
        </div>
    </div>
    @if ($c->approved_children()->count()>0)
        <ul>
            @foreach($c->approved_children as $cch)
                <li>
                    @include('starter-kit::component.comment', ['c' => $cch])
                </li>
            @endforeach
        </ul>
    @endif
</li>
