@extends('admin.templates.panel-list-template')

@section('list-title')
    <i class="ri-user-3-line"></i>
    {{__("Posts list")}}
@endsection
@section('title')
    {{__("Posts list")}} -
@endsection
@section('filter')
    <input type="hidden" id="group-edit-url" value="{{route('admin.post.group-edit','')}}/">
    {{--  Other filters --}}

    {{__("Main group")}}
    <searchable-multi-select
        :items='{{\App\Models\Group::all(['id','name'])}}'
        title-field="name"
        value-field="id"
        xlang="{{config('app.locale')}}"
        xname="filter[group_id]"
        :xvalue='{{request()->input('filter.group_id','[]')}}'
        :close-on-Select="true"></searchable-multi-select>
@endsection
@section('bulk')
        <option value="publish"> {{__("Publish")}} </option>
        <option value="draft"> {{__("Draft")}} </option>
@endsection
