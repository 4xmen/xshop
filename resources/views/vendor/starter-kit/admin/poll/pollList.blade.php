@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Polls")}}
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            {{__("Poll list")}}
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
                {{__("Deactive")}}
            </a>
            <a href="?filter=1" data-filter="1" class="btn btn-dark filter">
                {{__("Active")}}
            </a>
        </div>

        <form action="{{route('admin.poll.bulk')}}" method="post" class="bulk-action">
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
                        {{__("Body")}}
                    </th>
                    <th>
                        {{__("Status")}}
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
                @foreach($polls as $pl)
                    <tr>
                        <td>
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
                                <i class="ri-edit-2-fill"></i>
                            </a>
                            <a href="{{route('admin.poll.delete',$pl->slug)}}" class="btn btn-danger del-conf">
                                <i class="ri-close-line"></i>
                            </a>
                        </td>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$pl->id}}" class="m-2 chkbox"/>
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
    <a class="btn-add" href="{{route('admin.poll.create')}}">
        <i class="ri-add-line"></i>
    </a>
@endsection
