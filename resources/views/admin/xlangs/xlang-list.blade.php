@extends('admin.templates.panel-list-template')

@section('list-title')
    <i class="ri-user-3-line"></i>
    {{__("Languages list")}}
@endsection
@section('title')
    {{__("Languages list")}} -
@endsection
@section('filter')
    {{--  Other filters --}}
@endsection
@section('bulk')
    {{--    <option value="-"> - </option> --}}
@endsection
@section('list-foot')
    <a
        href="{{getRoute('translate')}}"
        class="action-btn circle-btn"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        data-bs-custom-class="custom-tooltip"
        data-bs-title="{{__("Sort")}}"
        style="inset-inline-end: 1.2rem;inset-inline-start: auto;"
    >
        <i class="ri-translate-2"></i>
    </a>
@endsection
