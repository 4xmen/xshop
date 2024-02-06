@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Advertise list")}}
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            {{__("Advertise list")}}
        </h1>
        @include('starter-kit::component.err')
        <div class="alert alert-dark">
            <span>
                {{__("Filter")}}:
            </span>
            <a href="{{route('admin.adv.index')}}" class="btn btn-dark" data-filter="all" >
                {{__("All")}}
            </a>
            <a href="?filter=0" data-filter="0" class="btn btn-dark filter">
                {{__("Deactive")}}
            </a>
            <a href="?filter=1" data-filter="1" class="btn btn-dark filter">
                {{__("Active")}}
            </a>
        </div>

        <form action="{{route('admin.adv.bulk')}}" method="post" class="bulk-action">
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
                        {{__("Image")}}
                    </th>
                    <th>
                        {{__("Link")}}
                    </th>
                    <th>
                        {{__("Click")}}
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
                @foreach($advs as $pl)
                    <tr>
                        <td>
                            {{$pl->id}}
                        </td>
                        <td>
                            {{$pl->title}}
                        </td>
                        <td>
                            <img src="{{$pl->imgUrl()}}" alt="" class="feature-image">
                        </td>
                        <td>
                            {{$pl->link}}
                        </td>
                        <td>
                            {{number_format($pl->click)}}
                        </td>
                        <td>
                            <div class="status posts-status-{{$pl->active}}"></div>
                        </td>
                        <td>
                            <a href="{{route('admin.adv.edit',$pl->id)}}" class="btn btn-secondary">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="{{route('admin.adv.delete',$pl->id)}}" class="btn btn-danger del-conf">
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
        {{$advs->links()}}
    </div>
    <a class="btn-add" href="{{route('admin.adv.create')}}">
        <i class="ri-add-line"></i>
    </a>
@endsection
