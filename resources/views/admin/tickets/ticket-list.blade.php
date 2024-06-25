@extends('admin.templates.panel-list-template')

@section('list-title')
    <i class="ri-user-3-line"></i>
    {{__("Tickets list")}}
@endsection
@section('title')
    {{__("Tickets list")}} -
@endsection
@section('filter')
    {{--  Other filters --}}
@endsection
@section('bulk')
        <option value="close"> {{__("Close")}} </option>
        <option value="pending"> {{__("Pending")}} </option>
        <option value="answered"> {{__("Answered")}} </option>
@endsection
