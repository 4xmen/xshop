@extends('website.inc.website-layout')

@section('title')
    {{$ticket->title}} - {{config('app.name')}}
@endsection
@section('content')
    <main>
        <div class="{{gfx()['container']}}" id="ticket-content">
            <a href="{{route('client.profile')}}" class="btn btn-primary float-end">
                <i class="ri-arrow-go-back-line"></i>
                {{__("Back to profile")}}
            </a>
            <h1>
                {{$ticket->title}}
            </h1>
            <div class="clearfix"></div>
            <div class="overflow-hidden">

                <div class="t-message">
                    <h6>
                        {{__("You")}}
                    </h6>
                    {{$ticket->body}}
                    <span class="t-time">
                    {{$ticket->created_at->ldate('Y-m-d H:i')}}
                </span>
                </div>
                @if($ticket->answer != null)
                    <div class="t-answer float-end">
                        <h6>
                            {{$ticket->user->name}}
                        </h6>
                        {{$ticket->answer}}
                        <span class="t-time">
                            {{$ticket->created_at->ldate('Y-m-d H:i')}}
                        </span>
                    </div>
                @endif
            </div>
            @foreach($ticket->subTickets as $t)
                <div class="overflow-hidden">

                    <div class="t-message">
                        <h6>
                            {{__("You")}}
                        </h6>
                        {{$t->body}}
                        <span class="t-time">
                            {{$t->created_at->ldate('Y-m-d H:i')}}
                        </span>
                    </div>
                    @if($t->answer != null)
                        <div class="t-answer float-end">
                            <h6>
                                {{$ticket->user->name}}
                            </h6>
                            {{$t->answer}}
                            <span class="t-time">
                                    {{$t->updated_at->ldate('Y-m-d H:i')}}
                            </span>
                        </div>
                    @endif
                </div>
            @endforeach
            <br>
            <hr>
            <form action="{{ route('client.ticket.answer', $ticket->id) }}" method="post">
                @csrf
                <div class="form-group mt-3">
                    <label for="body">
                        {{__("Answer")}}
                    </label>
                    <textarea rows="5" name="body" class="form-control" placeholder="{{__("Your answer ...")}}">{{old('body')}}</textarea>
                </div>
                <div class="mt-3">
                    <button class="btn btn-outline-primary w-100">
                        <i class="ri-send-plane-2-line"></i>
                        {{__("Send answer")}}
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
