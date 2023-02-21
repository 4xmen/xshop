@extends('website.layout')
@section('title')
    {{__("Invoice")}} - {{$invoice->id}}
@endsection
@section('content')
    <div id="main-conetent" class="container mt-5">
        <div class="border-x overflow-hidden">
        <img src="{{$qr->render(route('invoice.qr',$invoice->hash))}}" alt="qr code" style="max-width: 200px"
             class="float-end">
            <h2 class="pt-4">
                {{config('app.name')}}
            </h2>
            <hr>
            <div class="row">
                <td class="col-md-6">

                </td>
            </div>
            <div class="row">

                <div class="col-md">
                    <h4>
                        {{__("Invoice id")}}:
                        {{config('app.invoice_prefix')}}{{$invoice->id}}
                    </h4>
                </div>
                <div class="col-md">
                    <h4>
                        {{__("Invoice status")}}:
                        {{__($invoice->status)}}
                    </h4>
                </div>
                <div class="col-md text-end">
                    {{__($invoice->created_at->jdate('Y/m/d H:i:s'))}}
                </div>
            </div>
        </div>
        @include('component.invoice',$invoice)

        <hr>
        @if(auth('customer')->user()->colleague)
            <div class="border-x">
                <h4>
                    فرستنده:
                    {{auth('customer')->user()->name}}
                </h4>
                <h5>
                    شماره تماس:
                    {{auth('customer')->user()->mobile}}

                </h5>

            </div>
            <br>
            <div class="border-x">
                <h4>
                    گیرنده:
                    {{$invoice->desc}}
                </h4>
                <p>
                    آدرس:
                    {{$invoice->address_alt}}
                </p>
            </div>
        @else
            <div class="border-x">
                <h4>
                    گیرنده:
                    {{auth('customer')->user()->name}}
                </h4>
                <h5>
                    شماره تماس:
                    {{auth('customer')->user()->mobile}}
                </h5>
                <p>
                    آدرس:
                    {{$invoice->getAddress()}}
                </p>
            </div>
        @endif
    </div>
    <hr>
    <div class="text-center">
        <a href="{{route('invoice.pdf',$invoice->hash)}}" class="btn btn-light">
            {{__("Print")}}
        </a>
    </div>
@endsection
