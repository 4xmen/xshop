@extends('admin.adminlayout')
@section('page_title')
    {{__("Categories")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <form action="{{route('admin.cat.bulk')}}" method="post" class="bulk-action" >
            @csrf
            <table class="table table-striped table-bordered ">
                <thead class="thead-dark">
                <tr>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                    <th>
                        {{__("Image")}}
                    </th>
                    <th>
                        {{__("Name")}}
                    </th>
                    <th>
                        {{__("Parent")}}
                    </th>
                    <th>
                        {{__("Action")}}
                        <a href="{{route('admin.cat.create')}}" class="btn btn-success float-right"><i
                                class="fa fa-plus"></i></a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cats as $cat)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$cat->id}}" class="m-2 chkbox"/>
                            {{$cat->id}}
                        </td>
                        <td>
                            <img src="{{$cat->thumbUrl()}}" class="x64" alt="">
                        </td>
                        <td>
                            {{$cat->name}}
                        </td>
                        <td>
                            {{$cat->parent->name??'-'}}
                        </td>
                        <td>
                            <a href="{{route('admin.cat.edit',$cat->slug)}}" class="btn btn-primary">
                                <i class="fa fa-edit"></i> &nbsp;
                                {{__("Edit")}}
                            </a>
                            <a href="{{route('admin.cat.delete',$cat->slug)}}"
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
            {{$cats->links()}}
        </div>
    </div>
@endsection
