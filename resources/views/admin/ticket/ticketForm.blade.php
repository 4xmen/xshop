@extends('admin.adminlayout')
@section('page_title')
    @if(!isset($invoice))
        {{__('New invoice')}}
    @else
        {{__('Edit invoice')}}: {{$invoice->customer->name}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if(!isset($ticket))
                {{__('New ticket')}}
            @else
                {{__('Edit ticket')}}: {{$ticket->customer->name}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        <form id="invoice" method="post" action="{{route('admin.ticket.update',$ticket->id)}}" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-header bg-secondary text-light">
                    {{$ticket->title}}
                </div>
                <div class="card-body txt-area">{{$ticket->body}}</div>
                <div class="card-footer">
                    <textarea name="answer" class="form-control" rows="7" placeholder="{{__("Answer")}}..." minlength="5">{{$ticket->answer}}</textarea>
                </div>
            </div>
            @foreach($subTickets as $t)
                <div class="card mt-2">
                    <div class="card-body txt-area">{{$t->body}}</div>
                    <div class="card-footer">
                        <textarea name="answers[{{$t->id}}]" class="form-control" rows="7" placeholder="{{__("Answer")}}..." minlength="5">{{$t->answer}}</textarea>
                    </div>

                </div>
            @endforeach
            <div class="row mt-3">
                <div class="col-md">
                    <button class="btn btn-primary w-100" name="status" value="ANSWERED">
                        {{__("Send Answer")}}
                    </button>
                </div>
                <div class="col-md">
                    <button class="btn btn-success w-100 "  name="status" value="CLOSED">
                        {{__("Send Answer and close")}}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
