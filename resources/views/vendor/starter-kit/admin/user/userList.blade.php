@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Users")}}
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            {{__("User list")}}
            <a href="{{route('admin.user.create')}}" class="btn btn-success float-right">
                {{__("New user")}}
            </a>
        </h1>
        @include('starter-kit::component.err')
        <table class="table table-bordered table-striped">
            <tr>
                <th>
                    {{__("id")}}
                </th>
                <th>
                    {{__("Username")}}
                </th>
                <th>
                    {{__("Email")}}
                </th>
                <th>
                    {{__("Mobile")}}
                </th>
                <th>
                    {{__("action")}}
                </th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>
                        {{$user->id}}
                    </td>
                    <td>
                        {{$user->name}}
                    </td>
                    <td>
                        {{$user->email}}
                    </td>
                    <td>
                        {{$user->mobile}}
                    </td>
                    <td>
                        <a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-secondary">
                            {{__("Edit")}}
                        </a>
                        <a href="{{route('admin.user.delete',$user->id)}}" class="btn btn-danger del-conf">
                            {{__("Delete")}}
                        </a>
                        <a href="{{route('admin.logs.user',$user->id)}}" class="btn btn-dark">
                            {{__("Logs")}}
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$users->links()}}
    </div>
@endsection
