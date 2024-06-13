@extends('layouts.app')
@section('content')

    @if(hasRoute('create') && isset($item))
        <a class="action-btn circle-btn"
           data-bs-toggle="tooltip"
           data-bs-placement="top"
           data-bs-custom-class="custom-tooltip"
           data-bs-title="{{__("Add another one")}}"
           href="{{getRoute('create')}}"
        >
            <i class="ri-add-line"></i>
        </a>
    @else
        <a class="action-btn circle-btn"
           data-bs-toggle="tooltip"
           data-bs-placement="top"
           data-bs-custom-class="custom-tooltip"
           data-bs-title="{{__("Show list")}}"
           href="{{getRoute('index',[])}}"
        >
            <i class="ri-list-view"></i>
        </a>
    @endif
    <form
        @if(isset($item))
            id="model-form-edit"
            action="{{getRoute('update',$item->{$item->getRouteKeyName()})}}"
        @else
            id="model-form-create"
            action="{{getRoute('store')}}"
        @endif
          method="post" enctype="multipart/form-data">
        @csrf
        @if(isset($item))
            <input type="hidden" name="id" value="{{$item->id}}"/>
        @endif
        @yield('form')
    </form>
    @yield('out-of-form')
@endsection
