@extends('admin.adminlayout')
@section('page_title')
    {{__("Contacts")}}
    -
@endsection
@section('content')
    <div class="container">
        <h2>
            {{__('Contact list')}}
        </h2>
        @include('starter-kit::component.err')

        <form action="{{route('admin.contact.bulk')}}" method="post" class="bulk-action">
            @csrf
            <table class="table table-striped table-bordered ">
                <thead class="thead-dark">
                <tr>
                    <th>
                        <input type="checkbox" class="chkall"/>
                    </th>
                    <th>
                        {{__("Name and lastname")}}
                    </th>
                    <th>
                        {{__("phone")}}
                    </th>
                    <th>
                        {{__('Subject')}}
                    </th>
                    <th>
                        {{__("Date")}}
                    </th>
                    <th colspan="2">
                        {{__("Action")}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cons as $c)
                    <tr>
                        <td>
                            <input type="checkbox" name="id[]" value="{{$c->id}}" class="m-2 chkbox"/>
                            {{$c->id}}
                        </td>
                        <td>
                            {{$c->full_name}}
                        </td>
                        <td>
                            {{$c->phone}}
                        </td>
                        <td>
                            {{$c->subject}}
                        </td>
                        <td>
                            {{$c->created_at->jdate('Y/m/d')}}
                            {{$c->time}}
                        </td>
                        <td colspan="2" class="vac">

                            <a href="{{route('admin.contact.show',$c->id)}}"
                               class="btn-outline-info  btn-sm">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @include('starter-kit::component.bulk')
        </form>
        <div class="text-center pt-3">
            {{$cons->links()}}
        </div>
    </div>
@endsection
