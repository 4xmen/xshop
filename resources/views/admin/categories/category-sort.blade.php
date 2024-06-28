@extends('layouts.app')

@section('content')
    <div id="sort-control">
        {!! nestedWithData($items) !!}
    </div>
    <input type="hidden" id="sort-data" >

    <button
        data-link="{{route('admin.category.sort.save')}}"
        id="save-sort"
        class="action-btn circle-btn"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Save")}}"
            href="{{getRoute('create')}}"
    >
        <i class="ri-save-2-line"></i>
    </button>
@endsection

