@extends('website.layout.layout')
@section('title')
    {{__("Customer profile")}} -
@endsection
@section('content')
    <div id="main-conetent">
        <div class="container mt-3">
            @include('starter-kit::component.err')
            <div class="overflow-hidden">
                <div class="alert alert-dark w-50 float-start txt-area">{{$ticket->body}}
                    <i class="float-end"> {{$ticket->created_at->diffForHumans()}} </i>
                </div>
                <div class="clearfix"></div>
                @if(strlen($ticket->answer))
                    <div class="alert alert-success w-50 float-end txt-area">{{config('app.name')}}: {{$ticket->answer}}
                        <i class="float-end"> {{$ticket->updated_at->diffForHumans()}} </i>
                    </div>
                @endif
                @foreach($ticket->subTickets as $t)
                    <div class="clearfix"></div>
                    <div class="alert alert-info w-50 float-start txt-area">{{$t->body}}
                        <i class="float-end"> {{$t->created_at->diffForHumans()}} </i>
                    </div>
                    <div class="clearfix"></div>
                    @if(strlen($t->answer))
                        <div class="alert alert-success w-50 float-end txt-area"> {{config('app.name')}}: {{$t->answer}}
                        </div>
                    @endif
                @endforeach
            </div>
            <form class="row p-3" method="post" action="{{route('ticket.send')}}">
                @csrf
                <input type="hidden" name="parent_id" value="{{$ticket->id}}">
                <div class="col-12">
                    <div class="form-group">
                        <label for="body">
                            {{__("Answer")}}:
                        </label>
                        <textarea name="body" id="body" class="form-control"
                                  placeholder="{{__("Your question or request...")}}" rows="5"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100">
                        {{__("Send")}}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
