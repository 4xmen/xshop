@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Comments")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <div class="alert alert-dark">
            <span>
                {{__("Filter")}}:
            </span>
            <a href="{{route('admin.comment.index')}}" class="btn btn-dark" data-filter="all">
                {{__("All")}}
            </a>
            <a href="?filter=0" class="btn btn-dark filter" data-filter="0">
                {{__("Pending")}}
            </a>
            <a href="?filter=1" class="btn btn-dark filter" data-filter="1">
                {{__("Approved")}}
            </a>
            <a href="?filter=-1" class="btn btn-dark filter" data-filter="-1">
                {{__("Reject")}}
            </a>
        </div>
        <form action="{{route('admin.comment.bulk')}}" method="post" class="bulk-action">
            @csrf
            <table class="table table-striped table-bordered ">
                <thead class="thead-dark">
                <tr>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                    <th>
                        {{__("name / email")}}
                    </th>
                    <th style="width: 45%">
                        {{__("body")}}
                    </th>
                    <th>
                        {{__("Status")}}
                    </th>
                    <th colspan="2">
                        {{__("Action")}}
                        <a href="{{route('admin.post.create')}}" class="btn btn-success float-start"><i
                                class="fa fa-plus"></i></a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($comments as $c)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$c->id}}" class="m-2 chkbox"/>
                            {{$c->id}}
                        </td>
                        <td>
                            {{$c->name}}
                            <br>
                            {{$c->email}}
                            <br>
                            {{$c->ip}}
                        </td>
                        <td style="width: 40%">
                            {{$c->body}}
                        </td>
                        <td>
                            <div class="status comment-status-{{$c->status}}"></div>
                        </td>
                        <td colspan="2" class="vac">
                            @switch($c->status)
                                @case('1')
                                <a href="{{route('admin.comment.status',[$c->id,-1])}}" class="btn-sm btn-danger">
                                    <i class="fa fa-thumbs-down"></i>
                                </a>
                                <a href="{{route('admin.comment.status',[$c->id,0])}}" class="btn-sm btn-dark">
                                    <i class="fa fa-hourglass"></i>
                                </a>
                                @break
                                @case('-1')
                                <a href="{{route('admin.comment.status',[$c->id,1])}}" class="btn-sm btn-success">
                                    <i class="fa fa-thumbs-up"></i>
                                </a>
                                <a href="{{route('admin.comment.status',[$c->id,0])}}" class="btn-sm btn-dark">
                                    <i class="fa fa-hourglass"></i>
                                </a>
                                @break
                                @default
                                <a href="{{route('admin.comment.status',[$c->id,-1])}}" class="btn-sm btn-danger">
                                    <i class="fa fa-thumbs-down"></i>
                                </a>
                                <a href="{{route('admin.comment.status',[$c->id,1])}}" class="btn-sm btn-success">
                                    <i class="fa fa-thumbs-up"></i>
                                </a>
                            @endswitch
                            <a href="{{route('admin.comment.delete',$c->id)}}"
                               class="btn-danger delete-confirm btn-sm">
                                <i class="fa fa-times"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' =>['approve' => __("Approve"),'reject' => __("Reject"),"pending"=>__("Pending")]])
        </form>
        <div class="text-center pt-3">
            {{$comments->links()}}
        </div>
    </div>
@endsection
