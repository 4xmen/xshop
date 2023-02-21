@extends('website.emptylayout')
@section('title')
    {{__("Invoice")}} - {{$invoice->id}}
@endsection
@section('content')
    <div id="main-conetent" class="container mt-5">
        <img src="{{$qr->render(route('invoice.qr',$invoice->hash))}}" alt="qr code"  style="max-width: 200px" class="float-end">
        <h2 class="pt-4">
            {{config('app.name')}}
        </h2>
        <hr>
        <div class="row">
            <div class="col-md">
                <h4>
                    {{__("Invoice id")}}:
                    {{$invoice->id}}
                </h4>
            </div>
            <div class="col-md">
                    <h4>
                        {{__("Invoice status")}}:
                        {{__($invoice->status)}}
                    </h4>
            </div>
        </div>

        @include('component.invoice',$invoice)
    </div>
@endsection
