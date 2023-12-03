@extends('admin.adminlayout')
@section('page_title')
    {{__("Customers")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <form action="">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">
                            {{__("Name")}}
                        </label>
                        <input type="text" id="name" name="name" value="{{request()->input('name','')}}" placeholder="{{__("Name")}}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mobile">
                            {{__("Mobile")}}
                        </label>
                        <input type="text" id="mobile" name="mobile" value="{{request()->input('mobile','')}}" placeholder="{{__("Mobile")}}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md">
                    <br>
                    <input type="checkbox" @if(request()->has('colleague')) checked @endif id="colleague" class="mt-3" name="colleague" value="1">
                    &nbsp;
                    <label for="colleague" >
                        {{__("Colleague")}}
                    </label>
                </div>
                <div class="col-md">
                    <br>
                    <button class="btn btn-secondary">
                        {{__("Search")}}
                    </button>
                </div>
            </div>
        </form>
        <form action="{{route('admin.customer.bulk')}}" method="post" class="bulk-action" >
            @csrf
            <table class="table table-striped table-bordered ">
                <thead class="thead-dark">
                <tr>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                    <th>
                        {{__("Name")}}
                    </th>
                    <th>
                        {{__("Email")}}
                    </th>
                    <th>
                        {{__("Mobile")}}
                    </th>
                    <th>
                        {{__("Action")}}
                        <a href="{{route('admin.customer.create')}}" class="btn btn-success float-start"><i
                                class="fa fa-plus"></i></a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$customer->id}}" class="m-2 chkbox"/>
                            {{$customer->id}}
                        </td>
                        <td>
                            {{$customer->name}}
                        </td>
                        <td>
                            {{$customer->email}}
                        </td>
                        <td>
                            {{$customer->mobile}}
                        </td>
                        <td>
                            <a href="{{route('admin.customer.edit',$customer->id)}}" class="btn btn-primary">
                                <i class="fa fa-edit"></i> &nbsp;
                                {{__("Edit")}}
                            </a>
                            <a href="{{route('admin.customer.delete',$customer->id)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="fa fa-times"></i> &nbsp;
                                {{__("Delete")}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk')
        </form>
        <div class="text-center pt-3">
            {{$customers->appends(request()->input())->links()}}
        </div>
    </div>
@endsection
