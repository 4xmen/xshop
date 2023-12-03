@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Polls")}}
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            {{__("Poll list")}}
            <a href="{{route('admin.poll.create')}}" class="btn btn-success float-start">
                {{__("New Poll")}}
            </a>
        </h1>
        @include('starter-kit::component.err')
        <div class="alert alert-dark">
            <span>
                {{__("Filter")}}:
            </span>
            <a href="{{route('admin.poll.index')}}" class="btn btn-dark" data-filter="all" >
                {{__("All")}}
            </a>
            <a href="?filter=0" data-filter="0" class="btn btn-dark filter">
                {{__("Deactivate")}}
            </a>
            <a href="?filter=1" data-filter="1" class="btn btn-dark filter">
                {{__("Active")}}
            </a>
        </div>

        <form action="{{route('admin.poll.bulk')}}" method="post" class="bulk-action">
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
                        {{__("Body")}}
                    </th>
                    <th>
                        {{__("Status")}}
                    </th>
                    <th>
                        {{__("Action")}}
                        <a href="{{route('admin.poll.create')}}" class="btn btn-success float-start"><i
                                class="fa fa-plus"></i></a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($polls as $pl)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$pl->id}}" class="m-2 chkbox"/>
                            {{$pl->id}}
                        </td>
                        <td>
                            {{$pl->title}}
                        </td>
                        <td>
                            {{mb_substr(strip_tags($pl->body),0,65)}}...
                        </td>
                        <td>
                            <div class="status posts-status-{{$pl->active}}"></div>
                        </td>
                        <td>
                            <a href="{{route('admin.poll.edit',$pl->slug)}}" class="btn btn-secondary">
                                {{__("Edit")}}
                            </a>
                            <a href="{{route('admin.poll.delete',$pl->slug)}}" class="btn btn-danger del-conf">
                                {{__("Delete")}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' =>['active' => __("Active now"),'inactive' => __("Inactive now")]])
        </form>
        <br>
        {{$polls->links()}}
    </div>
@endsection
