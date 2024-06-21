@extends('admin.templates.panel-list-template')

@section('list-title')
    <i class="ri-user-3-line"></i>
    {{__("Products list")}}
@endsection
@section('title')
    {{__("Products list")}} -
@endsection
@section('filter')
    {{--  Other filters --}}
    <h2>
        <i class="ri-book-3-line"></i>
        {{__("Category")}}:
    </h2>
    <searchable-multi-select
        :items='{{\App\Models\Category::all(['id','name'])}}'
        title-field="name"
        value-field="id"
        xlang="{{config('app.locale')}}"
        xname="filter[category_id]"
        :xvalue='{{request()->input('filter.category_id','[]')}}'
        :close-on-Select="true"></searchable-multi-select>
@endsection
@section('bulk')
    {{--    <option value="-"> - </option> --}}

    <option value="publish"> {{__("Publish")}} </option>
    <option value="draft"> {{__("Draft")}} </option>
@endsection
