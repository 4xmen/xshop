@extends('admin.adminlayout')
@section('page_title')
    {{__("Categories")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <form action="{{route('admin.cat.bulk')}}" method="post" class="bulk-action" >
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
                        {{__("Parent")}}
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
                @foreach ($cats as $cat)
                    <tr>
                        <td>
                            {{$cat->id}}
                        </td>
                        <td>
                            <img src="{{$cat->thumbUrl()}}" class="x64" alt="">
                        </td>
                        <td>
                            {{$cat->name}}
                        </td>
                        <td>
                            {{$cat->parent->name??'-'}}
                        </td>
                        <td>
                            <a href="{{route('admin.cat.edit',$cat->slug)}}" class="btn btn-primary">
                               <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="{{route('admin.cat.delete',$cat->slug)}}"
                               class="btn btn-danger  delete-confirm">
                               <i class="ri-close-line"></i>
                            </a>
                            @if(config('app.xlang'))
                                <a href="{{route('admin.lang.model',[$cat->id,\App\Models\Cat::class])}}"
                                   class="btn btn-outline-dark translat-btn">
                                    <i class="ri-translate"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$cat->id}}" class="m-2 chkbox"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk')
        </form>
        <div class="text-center pt-3">
            {{$cats->links()}}
        </div>
        <a class="btn-add" href="{{route('admin.cat.create')}}">
            <i class="ri-add-line"></i>
        </a>
    </div>
@endsection
