@extends('layouts.app')

@section('content')
    <div id="sort-control">
        {!! nestedWithData($items) !!}
    </div>
    <input type="hidden" id="sort-data" >

    <button
        data-link="{{getRoute('sort-save')}}"
        id="save-sort"
        class="action-btn circle-btn"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Save")}}"
    >
        <i class="ri-save-2-line"></i>
    </button>
@endsection

