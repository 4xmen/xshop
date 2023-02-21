@extends('admin.adminlayout')
@section('page_title')
    {{__("Invoices")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <div class="alert alert-dark">
            <span>
                {{__("Filter")}}:
            </span>
            <a href="{{route('admin.invoice.index')}}" class="btn btn-dark" data-filter="all">
                {{__("All")}}
            </a>
            @foreach(['PENDING','PROCESSING','COMPLETED','CANCELED','FAILED'] as $f)
                <a href="?filter={{$f}}" data-filter="{{$f}}" class="btn btn-dark filter">
                    {{__($f)}}
                </a>
            @endforeach
        </div>
        <form action="{{route('admin.invoice.bulk')}}" method="post" class="bulk-action">
            @csrf
            <table class="table table-striped table-bordered ">
                <thead class="thead-dark">
                <tr>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                    <th>
                        {{__("Customer")}}
                    </th>
                    <th>
                        {{__("Total Price")}}
                    </th>
                    <th>
                        {{__("Product")}}
                    </th>
                    <th>
                        {{__("Status")}}
                    </th>
                    <th>
                        {{__("Date")}}
                    </th>
                    <th>
                        {{__('Payment Type')}}
                    </th>
                    <th>
                        {{__("Action")}}
                        {{--                        <a href="{{route('admin.invoice.create')}}" class="btn btn-success float-right"><i--}}
                        {{--                                class="fa fa-plus"></i></a>--}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$invoice->id}}" class="m-2 chkbox"/>
                        </td>
                        <td>
                            {{$invoice->customer->name}}
                        </td>
                        <td>
                            {{number_format($invoice->total_price)}}
                        </td>
                        <td>
                            {!! $invoice->products->implode('name',' <hr> ') !!}
                            @if($invoice->invoice != null)
                                [
                                <a href="{{route('customer.invoice',$invoice->invoice->hash)}}">
                                    {{__("Belong to")}}
                                </a>
                                ]
                            @endif
                        </td>
                        <td>
                            {{__($invoice->status)}}
                        </td>
                        <td>
                            {{__($invoice->created_at->jdate('Y/m/d H:i:s'))}}
                        </td>
                        <td>
                            {{$invoice->successPayments->implode('type',', ')}}
                        </td>
                        <td>
                            <a href="{{route('admin.invoice.edit',$invoice->hash)}}" class="btn btn-primary">
                                <i class="fa fa-edit"></i>

                            </a>
                            <a href="{{route('admin.invoice.delete',$invoice->hash)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="fa fa-times"></i>
                            </a>
                            <a href="{{route('admin.invoice.show',$invoice->hash)}}"
                               class="btn btn-secondary">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{route('invoice.pdf',$invoice->hash)}}"
                               class="btn btn-dark" target="_blank">
                                <i class="fa fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' =>[
                    'PENDING' => __("Pending"),
                    'PROCESSING' => __("Processing"),
                    'COMPLETED' => __("Completed"),
                    'CANCELED' => __("Canceled"),
                    'FAILED' => __("Failed")
                ]
            ])
        </form>
        <div class="text-center pt-3">
            {{$invoices->links()}}
        </div>
    </div>
@endsection
