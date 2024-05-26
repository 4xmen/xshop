@extends('layouts.app')

@section('content')
    <div class="mb-5 pb-5">
        <div class="row">

            {{--  list side bar start--}}
            <div class="col-xl-3 mb-3">
                <div class="item-list">
                    <div class="row">
                        <div class="col-8">
                            <h1>
                                @yield('list-title')
                            </h1>
                        </div>
                        <div class="col-4 pt-3 text-end">
                            @if(hasRoute('trashed'))
                                <a class="btn btn-outline-danger me-2"
                                   data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   data-bs-custom-class="custom-tooltip"
                                   data-bs-title="{{__("Trashed items")}}"
                                   href="{{getRoute('trashed')}}"
                                >
                                    <i class="ri-delete-bin-6-line"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <form action="" class="p-2">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="{{__("Search")}}..."
                                   aria-label="{{__("Search")}}..." aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                <i class="ri-search-2-line"></i>
                            </button>
                        </div>
                        @yield('filter')
                    </form>
                </div>
            </div>
            {{--  list side bar end--}}


            {{--   list content start--}}
            <div class="col-xl-9">
                <div class="item-list">
                    <table class="table-list">

                        <thead>
                        <tr>
                            <th>
                                <div
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-custom-class="custom-tooltip"
                                    data-bs-title="{{__("Check all")}}"
                                    class="form-check form-switch mt-1 mx-2">
                                    <input class="form-check-input chkall"
                                           type="checkbox" role="switch">
                                </div>
                            </th>
                            @foreach($cols as $col)
                                <th>
                                    <a href="?sort={{$col}}{{sortSuffix($col)}}">
                                        {{__($col)}}
                                    </a>
                                </th>
                            @endforeach
                            @yield('table-head')
                            <th class="text-center">
                                {{__("Totol")}}:
                                {{$items->total()}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" id="chk-{{$item->id}}" class="chkbox"
                                           name="id[{{$item->id}}]">
                                    <label for="chk-{{$item->id}}">
                                        {{$item->id}}
                                    </label>
                                </td>
                                @foreach($cols as $k => $col)
                                    @if($k == 0 && hasRoute('edit'))
                                        <td>
                                            <a href="{{getRoute('edit',$item->id)}}">
                                                <b>
                                                    {{$item->name}}
                                                </b>
                                            </a>
                                        </td>
                                    @else
                                        <td>
                                            {{$item->$col}}
                                        </td>
                                    @endif
                                @endforeach
                                @yield('table-body')
                                <td>
                                    @if(hasRoute('destroy'))
                                        <a href="{{getRoute('destroy',$item->id)}}"
                                           class="btn btn-outline-danger btn-sm mx-1"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="custom-tooltip"
                                           data-bs-title="{{__("Remove")}}">
                                            <i class="ri-close-line"></i>
                                        </a>
                                    @endif
                                    @if(hasRoute('edit'))
                                        <a href="{{getRoute('edit',$item->id)}}"
                                           class="btn btn-outline-primary btn-sm mx-1"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="custom-tooltip"
                                           data-bs-title="{{__("Edit")}}">
                                            <i class="ri-edit-2-line"></i>
                                        </a>
                                    @endif
                                    @if(hasRoute('show'))
                                        <a href="{{getRoute('show',$item->id)}}"
                                           class="btn btn-outline-secondary btn-sm mx-1"
                                           data-bs-toggle="tooltip"
                                           data-bs-placement="top"
                                           data-bs-custom-class="custom-tooltip"
                                           data-bs-title="{{__("Show")}}">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    @endif
                                    @yield('list-btn')
                                </td>
                            </tr>
                        @endforeach
                        </tbody>


                        {{-- pagination and toggle button start --}}
                        <tfoot>
                        <tr>
                            <th colspan="100%">
                                <div class="row">
                                    <div class="col-md-3 text-start">
                                        <div
                                            id="toggle-select"
                                            class="btn btn-outline-light mx-2"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-title="{{__("Toggle selection")}}">
                                            <i class="ri-toggle-line"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{$items->withQueryString()->links()}}
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <div class="p-2" data-bs-toggle="tooltip"
                                             data-bs-placement="top"
                                             data-bs-custom-class="custom-tooltip"
                                             data-bs-title="({{__("From - To - Total")}})">
                                            @paginated($items)
                                        </div>

                                    </div>
                                </div>
                            </th>
                        </tr>
                        </tfoot>
                        {{-- pagination and toggle button end --}}
                    </table>
                </div>
            </div>
            {{--   list content end--}}
        </div>
    </div>

    @if(hasRoute('create'))
        <a class="action-btn circle-btn"
           data-bs-toggle="tooltip"
           data-bs-placement="top"
           data-bs-custom-class="custom-tooltip"
           data-bs-title="{{__("Add another one")}}"
           href="{{getRoute('create')}}"
        >
            <i class="ri-add-line"></i>
        </a>
    @endif
@endsection
