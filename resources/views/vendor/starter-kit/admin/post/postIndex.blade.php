@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Posts")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <div class="alert alert-dark">
            <span>
                {{__("Filter")}}:
            </span>
            <a href="{{route('admin.post.index')}}" class="btn btn-dark" data-filter="all" >
                {{__("All")}}
            </a>
            <a href="?filter=0" data-filter="0" class="btn btn-dark filter">
                {{__("Drafted")}}
            </a>
            <a href="?filter=1" data-filter="1" class="btn btn-dark filter">
                {{__("Published")}}
            </a>
        </div>
        <form action="{{route('admin.post.bulk')}}" method="post" class="bulk-action">
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
                        {{__("Title")}}
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
                @foreach ($posts as $n)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$n->id}}" class="m-2 chkbox"/>
                            {{$n->id}}
                        </td>
                        <td>
                            @if($n->getMedia()->count() > 0)
                                <img src="{{$n->imgurl()}}" class="feature-image" alt="">
                            @endif
                        </td>
                        <td>
                            {{$n->title}}
                        </td>
                        <td>
                            <div class="status post-status-{{$n->status}}"></div>
                        </td>
                        <td>
                            <a href="{{route('admin.post.edit',$n->slug)}}" class="btn btn-primary">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="{{route('admin.post.delete',$n->slug)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="ri-close-line"></i>
                            </a>
                            @if(config('app.xlang'))
                                <a href="{{route('admin.lang.model',[$n->id,\Xmen\StarterKit\Models\Post::class])}}"
                                   class="btn btn-outline-dark translat-btn">
                                    <i class="ri-translate"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' =>['draft' => __("Draft now"),'publish' => __("Publish now")]])
        </form>
        <div class="text-center pt-3">
            {{$posts->links()}}
        </div>
        <a class="btn-add" href="{{route('admin.post.create')}}">
            <i class="ri-add-line"></i>
        </a>
    </div>
@endsection
