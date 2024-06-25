@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit ticket")}} [{{$item->title}}]
    @else
        {{__("Add new ticket")}}
    @endif -
@endsection
@section('form')

    <div class="row">
        <div class="col-lg-3">

            @include('components.err')
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-message-3-line"></i>
                    {{__("Tips")}}
                </h3>
                <ul>
                    <li>
                        {{__("Recommends")}}
                    </li>
                </ul>
            </div>

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit ticket")}} [{{$item->title}}]
                    @else
                        {{__("Add new ticket")}}
                    @endif
                </h1>

                    <div class="card">
                        <div class="card-body txt-area">{{$item->body}}</div>
                        <div class="card-footer">
                            <textarea name="answer" class="form-control" rows="7" placeholder="{{__("Answer")}}..." minlength="5">{{$item->answer}}</textarea>
                        </div>
                    </div>
                    @foreach($item->subTickets as $t)
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

            </div>
        </div>
    </div>
@endsection
