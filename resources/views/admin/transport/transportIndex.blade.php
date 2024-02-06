
@extends('admin.adminlayout')
@section('page_title')
    {{__("Transports")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <form action="{{route('admin.transport.bulk')}}" method="post" class="bulk-action">
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
                        {{__("Price")}}
                    </th>
                    <th>
                        {{__("Action")}}
                    </th>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($transports as $n)
                    <tr>
                        <td>
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
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="{{route('admin.transport.delete',$n->id)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="ri-close-line"></i>
                            </a>
                        </td>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$n->id}}" class="m-2 chkbox"/>
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
        <a class="btn-add" href="{{route('admin.transport.create')}}">
            <i class="ri-add-line"></i>
        </a>
    </div>
@endsection
