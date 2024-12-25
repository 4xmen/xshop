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
    <div id="iframe-modal">
        <div class="container">
            <iframe href="#"></iframe>
        </div>
    </div>
    {{--  Other filters --}}
@endsection
@section('bulk')
        <option value="publish"> {{__("Publish")}} </option>
        <option value="draft"> {{__("Draft")}} </option>
@endsection
