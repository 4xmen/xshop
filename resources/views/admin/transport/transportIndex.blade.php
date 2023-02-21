@extends('admin.adminlayout')
@section('page_title')
    {{__("Discounts")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <form action="{{route('admin.transport.bulk')}}" method="post" class="bulk-action">
            @csrf
            <table class="table table-striped table-bordered ">
                <thead class="thead-dark">
                <tr>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                    <th>
                        {{__("Title")}}
                    </th>
                    <th>
                        {{__("Price")}}
                    </th>
                    <th>
                        {{__("Action")}}
                        <a href="{{route('admin.transport.create')}}" class="btn btn-success float-right"><i
                                class="fa fa-plus"></i></a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($transports as $n)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$n->id}}" class="m-2 chkbox"/>
                            {{$n->id}}
                        </td>
                        <td>
                            {{__($n->title)}}
                        </td>
                        <td>
                                {{number_format($n->price)}}
                        </td>
                        <td>
                            <a href="{{route('admin.transport.edit',$n->id)}}" class="btn btn-primary">
                                <i class="fa fa-edit"></i> &nbsp;
                                {{__("Edit")}}
                            </a>
                            <a href="{{route('admin.transport.delete',$n->id)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="fa fa-times"></i> &nbsp;
                                {{__("Delete")}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' => []])
        </form>
        <div class="text-center pt-3">
            {{$transports->links()}}
        </div>
    </div>
@endsection
