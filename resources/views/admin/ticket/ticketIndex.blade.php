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
            <a href="{{route('admin.ticket.index')}}" class="btn btn-dark" data-filter="all">
                {{__("All")}}
            </a>
            @foreach(['PENDING','ANSWERED','CLOSED'] as $f)
                <a href="?filter={{$f}}" data-filter="{{$f}}" class="btn btn-dark filter">
                    {{__($f)}}
                </a>
            @endforeach
        </div>
        <form action="{{route('admin.ticket.bulk')}}" method="post" class="bulk-action">
            @csrf
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        {{__("Title")}}
                    </th>
                    <th>
                        {{__("Customer")}}
                    </th>
                    <th>
                        {{__("Status")}}
                    </th>
                    <th>
                        {{__("Action")}}
                        {{--                        <a href="{{route('admin.invoice.create')}}" class="btn btn-success float-start"><i--}}
                        {{--                                class="fa fa-plus"></i></a>--}}
                    </th>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                    <tr>
                        <td>
                            {{$ticket->id}}
                        </td>
                        <td>
                            {{$ticket->title}}
                        </td>
                        <td>
                            <a href="{{route('admin.customer.edit',$ticket->customer->id)}}">
                                {{$ticket->customer->name}}
                            </a>
                        </td>
                        <td>
                            {{__($ticket->status)}}
                        </td>
                        <td>
                            <a href="{{route('admin.ticket.edit',$ticket->id)}}" class="btn btn-primary">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="{{route('admin.ticket.delete',$ticket->id)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="ri-close-line"></i>
                            </a>
                        </td>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$ticket->id}}" class="m-2 chkbox"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' =>['CLOSED' => __("CLOSED"),]])
        </form>
        <div class="text-center pt-3">
            {{$tickets->links()}}
        </div>

        <h3>
            {{__("New ticket")}}
        </h3>
        <form method="post" action="{{route('admin.ticket.store')}}">
            @csrf
            <div class="row">
                <div class="col mt-3">
                    <div class="form-group">
                        <label for="customer_id">
                            {{__('Customer')}}
                        </label>
                        <select name="customer_id" data-live-search="true" id="customer_id"
                                class="form-control searchable  @error('customer_id') is-invalid @enderror">
                            @foreach(\App\Models\Customer::all() as $customer )
                                <option value="{{ $customer->id }}"
                                        @if (old('customer_id') == $customer->id ) selected @endif > {{$customer->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">
                            {{__("Title")}}
                        </label>
                        <input type="text" id="title" name="title" value="{{old('title')}}" placeholder="{{__("Title")}}" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="body">
                            {{__("Text")}}
                        </label>
                        <textarea name="body" id="body" class="form-control" placeholder="{{__("Your question or request...")}}" rows="5">{{old('body')}}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary w-100">
                        {{__("Send")}}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
