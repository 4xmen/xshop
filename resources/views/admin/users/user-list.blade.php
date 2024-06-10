@extends('admin.templates.panel-list-template')

@section('list-title')
    <i class="ri-user-3-line"></i>
    {{__("Users list")}}
@endsection
@section('title')
    {{__("Users list")}} -
@endsection
@section('filter')
    <h2>
        <i class="ri-shield-check-line"></i>
        {{__("Role filter")}}:
    </h2>
    <searchable-multi-select
        :items='{{arrayNormolizeVueCompatible(\App\Models\User::$roles, true)}}'
        title-field="name"
        value-field="name"
        xname="filter[role]"
        :xvalue='{{request()->input('filter.role','[]')}}'
        :close-on-Select="true"></searchable-multi-select>
@endsection
@section('bulk')
    @foreach(\App\Models\User::$roles as $role)
    <option value="role.{{$role}}"> {{__("Set")}} {{__("$role")}} </option>
    @endforeach
@endsection
