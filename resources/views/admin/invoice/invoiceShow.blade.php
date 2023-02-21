@extends('admin.adminlayout')
@section('page_title')
    {{__("Invoices")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        @include('component.invoice',$invoice)
        <div class="card">
            <div class="card-header">
                {{__("Customer")}}
            </div>
            <div class="card-body">
                {{__("Name")}}:
                <a href="{{route('admin.customer.edit',$invoice->customer->id)}}">
                    <b>
                        {{$invoice->customer->name}}
                    </b>
                </a>
                <hr>
                {{__("Address")}}:
                <b>
                    {{$invoice->getAddress()}}
                </b>
                <hr>
                {{__("Description")}}:
                <b>
                    {{$invoice->desc}}
                </b>
            </div>
        </div>
    </div>
@endsection
