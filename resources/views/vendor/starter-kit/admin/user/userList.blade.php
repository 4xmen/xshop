@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Users")}}
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            {{__("User list")}}
        </h1>
        @include('starter-kit::component.err')
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th>
                    #
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
                        <a href="{{route('admin.user.edit',$user->id)}}" class="btn btn-primary">
                            <i class="ri-edit-2-fill"></i>
                        </a>
                        <a href="{{route('admin.user.delete',$user->id)}}" class="btn btn-danger del-conf">
                            <i class="ri-close-line"></i>
                        </a>
                        <a href="{{route('admin.logs.user',$user->id)}}" class="btn btn-dark">
                            <i class="ri-news-line"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$users->links()}}
    </div>
    <a class="btn-add" href="{{route('admin.user.create')}}">
        <i class="ri-add-line"></i>
    </a>
@endsection
