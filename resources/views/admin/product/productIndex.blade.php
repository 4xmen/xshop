@extends('admin.adminlayout')
@section('page_title')
    {{__("Products")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')

        <form action="" class="my-2">
            <label for="q">
            </label>
            <input id="q" type="search" name="q" value="{{request()->get('q')}}" class="form-control" placeholder="{{__("Search")}}...">
        </form>
        <div class="alert alert-dark">
            <span>
                {{__("Filter")}}:
            </span>
            <a href="{{route('admin.product.index')}}" class="btn btn-dark" data-filter="all" >
                {{__("All")}}
            </a>
            @foreach( App\Helpers\stockTypes() as $k => $filter)
            <a href="?filter={{$k}}" data-filter="{{$k}}" class="btn btn-dark filter">
                {{$filter}}
            </a>
            @endforeach
            <a href="?filter=TRASH" data-filter="TRASH" class="btn btn-dark filter">
                <span class="fa fa-trash"></span>
                {{__("Trashed")}}
            </a>


        </div>
        <form action="{{route('admin.product.bulk')}}" method="post" class="bulk-action">
            @csrf
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        {{__("Image")}}
                    </th>
                    <th>
                        {{__("Name")}}
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
                @foreach ($products as $n)
                    <tr>
                        <td>
                            {{$n->id}}
                        </td>
                        <td>
                            @if($n->getMedia()->count() > 0)
                                <img src="{{$n->thumbUrl()}}" class="feature-image" alt="">
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.product.edit',$n->slug)}}">
                                {{$n->name}}
                            </a>
                        </td>
                        <td>
                            <div class="status products-status-{{$n->status}}"></div>
                        </td>
                        <td>
                            <a href="{{route('admin.product.edit',$n->slug)}}" class="btn btn-primary">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            @if($n->deleted_at == null)
                            <a href="{{route('admin.product.delete',$n->slug)}}"
                               class="btn btn-danger  delete-confirm">
                                <i class="ri-close-line"></i>
                            </a>
                            @if(config('app.xlang'))
                                <a href="{{route('admin.lang.model',[$n->id,\App\Models\Product::class])}}"
                                   class="btn btn-outline-dark translat-btn">
                                    <i class="ri-translate"></i>
                                </a>
                            @endif
                            @else
                                <a href="{{route('admin.product.restore',$n->slug)}}"
                                   class="btn btn-success">
                                    <i class="fa fa-refresh"></i> &nbsp;
                                    {{__("Restore")}}
                                </a>
                            @endif
                        </td>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$n->id}}" class="m-2 chkbox"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' => App\Helpers\stockTypes()])
        </form>
        <div class="text-center pt-3">
            {{$products->links()}}
        </div>
        <a class="btn-add" href="{{route('admin.post.create')}}">
            <i class="ri-add-line"></i>
        </a>
    </div>
@endsection
