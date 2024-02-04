@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Clips")}}
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            {{__("Clip list")}}
            <a href="{{route('admin.clip.create')}}" class="btn btn-success float-start">
                {{__("New Clip")}}
            </a>
        </h1>
        @include('starter-kit::component.err')
        <div class="alert alert-dark">
            <span>
                {{__("Filter")}}:
            </span>
            <a href="{{route('admin.clip.index')}}" class="btn btn-dark" data-filter="all" >
                {{__("All")}}
            </a>
            <a href="?filter=0" data-filter="0" class="btn btn-dark filter">
                {{__("Deactive")}}
            </a>
            <a href="?filter=1" data-filter="1" class="btn btn-dark filter">
                {{__("Active")}}
            </a>
        </div>

        <form action="{{route('admin.clip.bulk')}}" method="post" class="bulk-action">
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
                        {{__("Cover")}}
                    </th>
                    <th>
                        {{__("Status")}}
                    </th>
                    <th>
                        {{__("Action")}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($clips as $pl)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$pl->id}}" class="m-2 chkbox"/>
                            {{$pl->id}}
                        </td>
                        <td>
                            {{$pl->title}}
                        </td>
                        <td>
                            <img src="{{$pl->coverUrl()}}" alt="" class="feature-image">
                        </td>
                        <td>
                            <div class="status posts-status-{{$pl->active}}"></div>
                        </td>
                        <td>
                            <a href="{{route('admin.clip.edit',$pl->slug)}}" class="btn btn-secondary">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="{{route('admin.clip.delete',$pl->slug)}}" class="btn btn-danger del-conf">
                                <i class="ri-close-line"></i>
                            </a>
                            @if(config('app.xlang'))
                                <a href="{{route('admin.lang.model',[$n->id,\Xmen\StarterKit\Models\Clip::class])}}"
                                   class="btn btn-outline-dark translat-btn">
                                    <i class="ri-translate"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' =>['active' => __("Active now"),'inactive' => __("Inactive now")]])
        </form>
        <br>
        {{$clips->links()}}
        <a class="btn-add" href="{{route('admin.clip.create')}}">
            <i class="ri-add-line"></i>
        </a>
    </div>

@endsection
