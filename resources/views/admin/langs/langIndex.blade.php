@extends('admin.adminlayout')
@section('page_title')
    {{__("Languages")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
        <form action="{{route('admin.lang.bulk')}}" method="post" class="bulk-action">
            @csrf
            <table class="table table-striped table-bordered text-center ">
                <thead class="thead-dark">
                <tr>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                    <th>

                            {{__("Name")}}
                    </th>
                    <th>
                        {{__("Tag")}}
                    </th>
                    <th>
                        {{__("Direction")}}
                    </th>
                    <th>
                        {{__("Action")}}

                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($langs as $n)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$n->id}}" class="m-2 chkbox"/>
                            {{$n->id}}
                        </td>
                        <td>
                            <a href="{{route('admin.lang.edit',$n->id)}}">
                            {{$n->name}}
                            </a>
                        </td>
                        <td>
                            {{$n->tag}}
                        </td>
                        <td>
                            @if($n->rtl)
                                {{__("RTL")}}
                            @else
                                {{__("LTR")}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.lang.edit',$n->id)}}" class="btn btn-primary btn-sm">
                                <i class="ri-edit-2-line"></i>
                            </a>
                            <a href="{{route('admin.lang.delete',$n->id)}}"
                               class="btn btn-danger  delete-confirm btn-sm">
                                <i class="ri-close-line"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk',['actions' => []])
        </form>
        <div class="text-center pt-3">
            {{$langs->links()}}
        </div>
        <a class="btn-add" href="{{route('admin.lang.create')}}">
            <i class="ri-add-line"></i>
        </a>
    </div>
@endsection
