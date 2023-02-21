@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Menus")}}
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            {{__("Menus list")}}
        </h1>
        @include('starter-kit::component.err')

        <table class="table table-striped table-bordered ">
            <thead class="thead-dark">
            <tr>
                <th>
                    -
                </th>
                <th>
                    {{__("Name")}}
                </th>
                <th>
                    {{__("Action")}}
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($menus as $menu)
                <tr>
                    <td>
                        {{$menu->id}}
                    </td>
                    <td>
                        {{$menu->name}}
                    </td>
                    <td>
                        <a href="{{route('admin.menu.manage',$menu->id)}}" class="btn btn-secondary">
                            {{__("Manage")}}
                        </a>
                        <a href="{{route('admin.menu.delete',$menu->id)}}" class="btn btn-danger del-conf">
                            {{__("Delete")}}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <form method="post" action="{{route('admin.menu.store')}}" class="card">
            <div class="card-header">
                {{__("New menu")}}
            </div>
            @csrf
            <div class="row p-4">
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="name">
                            {{__('Name')}}
                        </label>
                        <input type="text" id="name" name="name" value="{{old('name')}}" placeholder="{{__('Name')}}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-md-2 mt-2">
                    <br>
                    <input type="submit" class="btn btn-success" value="{{__('Save')}}"/>
                </div>
            </div>
        </form>
        <br>
        {{$menus->links()}}
    </div>
@endsection
