@extends('layouts.app')

@section('content')
    <div class="mb-5 pb-5">
        <div class="row">

            {{--  list side bar start--}}
            <div class="col-xl-3">
                @include('components.err')
                <div class="item-list mb-3">
                    <div class="row">
                        <div class="col-8">
                            <h1>
                                @yield('list-title')
                            </h1>
                        </div>
                        <div class="col-4 pt-3 text-end">
                            @if(hasRoute('trashed'))
                                <a class="btn btn-outline-danger me-3"
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
                    <form action="" class="p-3">
                        <div class="input-group mb-3">
                            <span class="btn btn-outline-secondary" type="button" id="button-addon2">
                                <i class="ri-search-2-line"></i>
                            </span>
                            <input type="text" name="q" class="form-control" placeholder="{{__("Search")}}..."
                                   aria-label="{{__("Search")}}..." aria-describedby="button-addon2"
                                   value="{{request()->input('q','')}}">
                        </div>
                        @yield('filter')
                        <button class="btn btn-primary w-100">
                            {{__("Search & Filter")}}
                        </button>
                    </form>
                </div>

                @yield('side-raw')

                <div class="item-list mb-3 py-3">
                    <div class="grid-equal text-center p-1">
                        <span>
                             {{__("Total")}}
                        </span>
                        <span>
                            ({{$items->total()}})
                        </span>
                    </div>
                    <hr>
                    <div class="grid-equal text-center p-1">
                        <span>
                             {{__("From - To")}}
                        </span>
                        <span>
                             @paginated($items)
                        </span>
                    </div>
                </div>

                @if(hasRoute('bulk'))

                    <div class="item-list mb-3">
                        <h3 class="p-3">
                            <i class="ri-check-double-line"></i>
                            {{__("Bulk actions:")}}
                        </h3>
                        <form action="{{getRoute('bulk',[])}}" id="bulk-from" method="post">

                            <div class="p-3">

                                @csrf
                                <select class="form-control mb-3" name="action" required>
                                    <option value=""></option>
                                    @if(strpos(request()->url(),'trashed') != false)
                                        <option value="restore"> {{__("Batch restore")}} </option>
                                    @else
                                        <option value="delete"> {{__("Batch delete")}} </option>
                                    @endif
                                    @yield('bulk')
                                </select>

                                <button class="btn btn-primary w-100">
                                    {{__("Do it")}}
                                </button>
                                <div id="bulk-idz"></div>
                            </div>
                        </form>
                    </div>
                @endif


            </div>
            {{--  list side bar end--}}


            {{--   list content start--}}
            <div class="col-xl-9 ps-xl-0">
                <form class="item-list" id="main-form">
                    @yield('table')
                </form>
            </div>
        </div>
        {{--   list content end--}}
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
