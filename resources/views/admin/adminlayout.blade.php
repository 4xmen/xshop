@extends('starter-kit::layouts.adminlayout')
@section('header-content')
    @include('component.lang')
@endsection
@section('js-content')
    @yield('content-with-js')
@endsection
