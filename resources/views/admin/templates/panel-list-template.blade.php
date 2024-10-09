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
                            @if(isset($items[0]) && method_exists($items[0],'imgUrl'))
                                <th>
                                    {{__("image")}}
                                </th>
                            @endif
                            @foreach($cols as $col)
                                <th>
                                    <a href="?sort={{$col}}{{sortSuffix($col)}}&{{queryBuilder('sort')}}">
                                        {{__($col)}}
                                    </a>
                                </th>
                            @endforeach
                            {{--                            @yield('table-head')--}}
                            <th>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($items) == 0)
                            <tr>
                                <td colspan="100%">
                                    {{__("There is nothing to show!")}}
                                </td>
                            </tr>
                        @else
                            @foreach($items as $item)
                                <tr>

                                    <td>
                                        <input type="checkbox" id="chk-{{$item->id}}" class="chkbox"
                                               name="id[{{$item->id}}]" value="{{$item->id}}">
                                        <label for="chk-{{$item->id}}">
                                            {{$item->id}}
                                        </label>
                                    </td>
                                    @if(isset($item) && method_exists($item,'imgUrl'))
                                        <td>
                                            <a href="{{getRoute('edit',$item->{$item->getRouteKeyName()})}}">
                                                <img src="{{$item->imgUrl()}}" class="image-x64" alt="">
                                            </a>
                                        </td>
                                    @endif
                                    @foreach($cols as $k => $col)
                                        @if($k == 0 && hasRoute('edit'))
                                            <td>
                                                <a href="{{getRoute('edit',$item->{$item->getRouteKeyName()})}}">
                                                    <b>
                                                        {{strip_tags($item?->{$cols[0]}) }}
                                                    </b>
                                                </a>
                                            </td>
                                        @else
                                            <td>
                                                @switch($col)
                                                    @case('parent_id')
                                                        {{ $item->parent?->{$cols[0]}??'-' }}
                                                        @break
                                                    @case('status')
                                                        <div class="model-status status-{{$item->status}} float-start"
                                                             data-bs-toggle="tooltip"
                                                             data-bs-placement="top"
                                                             data-bs-custom-class="custom-tooltip"
                                                             data-bs-title="{{$item->status}}"></div>
                                                        @break
                                                    @case('user_id')
                                                        @if($item->user != null)
                                                            <a href="{{route('admin.user.edit',$item->user?->email)}}">
                                                                {{ $item->user?->name??'-' }}
                                                            </a>
                                                        @else
                                                            {{__("Removed")}}
                                                        @endif
                                                        @break
                                                    @case('customer_id')
                                                        @if($item->customer != null)
                                                            <a href="{{route('admin.customer.edit',$item->customer?->id)}}">
                                                                {{ $item->customer?->name??'-' }}
                                                            </a>
                                                        @else
                                                            {{__("Removed")}}
                                                        @endif
                                                        @break
                                                    @case('category_id')
                                                        @if($item->category != null)
                                                            <a href="{{route('admin.category.edit',$item->category?->slug)}}">
                                                                {{ $item->category?->name??'-' }}
                                                            </a>
                                                        @else
                                                            {{__("Removed")}}
                                                        @endif
                                                        @break
                                                    @case('state_id')
                                                        @if($item->state != null)
                                                            <a href="{{route('admin.state.edit',$item->state?->id)}}">
                                                                {{ $item->state?->name??'-' }}
                                                            </a>
                                                        @else
                                                            {{__("Removed")}}
                                                        @endif
                                                        @break
                                                    @case('product_id')
                                                        @if($item->product != null)
                                                            <a href="{{route('admin.product.edit',$item->product?->slug)}}">
                                                                {{ $item->product?->name??'-' }}
                                                            </a>
                                                        @else
                                                            {{__("Removed")}}
                                                        @endif
                                                        @break
                                                    @case('evaluation_id')
                                                        @if($item->evaluation != null)
                                                            <a href="{{route('admin.evaluation.edit',$item->evaluation_id)}}">
                                                                {{ $item->evaluation?->title??'-' }}
                                                            </a>
                                                        @else
                                                            {{__("Removed")}}
                                                        @endif
                                                        @break
                                                    @case('expire')
                                                    @case('created_at')
                                                    @case('updated_at')
                                                        {{$item->$col?->ldate("Y-m-d H:i")??'-'}}
                                                        @break
                                                    @case('icon')
                                                        <i class="{{$item->$col}}"></i>
                                                        @break
                                                    @default
                                                        @if(substr($col,0,3) == 'is_')
                                                            @if($item->$col == 1)
                                                                <i class="ri-check-line"></i>
                                                            @endif
                                                        @elseif(gettype($item->$col) == 'integer')
                                                            {{number_format($item->$col)}}
                                                        @elseif(strpos($col,'_type'))
                                                            {{str_replace('App\\Models\\', '' , $item->$col)}}
                                                        @else
                                                            {{$item->$col}}
                                                        @endif
                                                @endswitch
                                            </td>
                                        @endif
                                    @endforeach
                                    {{--                                    @yield('table-body')--}}
                                    <td>

                                        @if(strpos(request()->url(),'trashed') != false && hasRoute('restore'))
                                            <a href="{{getRoute('restore',$item->{$item->getRouteKeyName()})}}"
                                               class="btn btn-success btn-sm mx-1 d-xl-none d-xxl-none"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               data-bs-custom-class="custom-tooltip"
                                               data-bs-title="{{__("Restore")}}">
                                                <i class="ri-recycle-line"></i>
                                            </a>
                                        @else

                                            <div class="dropdown d-xl-none d-xxl-none">
                                                <a class="btn btn-outline-secondary dropdown-toggle" href="#"
                                                   role="button"
                                                   data-bs-toggle="dropdown" aria-expanded="false">
                                                </a>
                                                <ul class="dropdown-menu">
                                                    @foreach($buttons as $btn => $btnData)
                                                        <li>
                                                            <a class="dropdown-item {{$btnData['class']}}"
                                                               href="{{getRoute($btn,$item->{$item->getRouteKeyName()})}}">
                                                                <i class="{{$btnData['icon']}}"></i>
                                                                &nbsp;
                                                                {{__($btnData['title'])}}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                    @if(config('app.xlang.active') && isset($item->translatable))
                                                        <li>
                                                            <a class="dropdown-item"
                                                               href="{{route('admin.lang.model',[$item->id, get_class($item)])}}">
                                                                <i class="ri-translate"></i>
                                                                &nbsp;
                                                                {{__("Translate")}}
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="d-none d-xl-block  d-xxl-block">
                                            @foreach($buttons as $btn => $btnData)

                                                @if(strpos($btnData['class'],'delete') == false )
                                                    @if(strpos(request()->url(),'trashed') == false)

                                                        <a href="{{getRoute($btn,$item->{$item->getRouteKeyName()})}}"
                                                           class="btn {{$btnData['class']}} btn-sm mx-1"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-placement="top"
                                                           data-bs-custom-class="custom-tooltip"
                                                           data-bs-title="{{__($btnData['title'])}}">
                                                            <i class="{{$btnData['icon']}}"></i>
                                                        </a>
                                                    @endif
                                                @else
                                                    @if( hasRoute('restore') && $item->trashed())
                                                        <a class="btn btn-success btn-sm mx-1"
                                                           href="{{getRoute('restore',$item->id)}}"
                                                           {{--dont change this id to getRouteKeyName --}}
                                                           data-bs-toggle="tooltip"
                                                           data-bs-placement="top"
                                                           data-bs-custom-class="custom-tooltip"
                                                           data-bs-title="{{__("Restore")}}">
                                                            <i class="ri-recycle-line"></i>
                                                        </a>
                                                    @else
                                                        <a href="{{getRoute($btn,$item->{$item->getRouteKeyName()})}}"
                                                           class="btn {{$btnData['class']}} btn-sm mx-1"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-placement="top"
                                                           data-bs-custom-class="custom-tooltip"
                                                           data-bs-title="{{__($btnData['title'])}}">
                                                            <i class="{{$btnData['icon']}}"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            @endforeach
                                            @if(config('app.xlang.active') && isset($item->translatable))
                                                <a href="{{route('admin.lang.model',[$item->id, get_class($item)])}}"
                                                   class="btn btn-outline-secondary translat-btn btn-sm mx-1">
                                                    <i class="ri-translate"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                        @endif

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
                                    </div>
                                </div>
                            </th>
                        </tr>
                        </tfoot>
                        {{-- pagination and toggle button end --}}
                    </table>
                </form>
            </div>
        </div>
        {{--   list content end--}}
    </div>

    @yield('list-foot')
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
