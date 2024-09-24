<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="xShop control panel - {{config('app.name')}}">
    <meta name="generator" content="xShop; version={{config('app.version')}}">
    {{--  open graph  --}}
    <meta property="og:site_name" content="{{config('app.name')}}" />
    <meta property="og:locale" content="{{config('app.locale')}}">
    <meta property="og:title" content="{{config('app.name')}}" />
    <meta property="og:image" content="{{asset('upload/images/logo.svg')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') {{ config('app.name', 'Laravel') }}</title>

    @include('components.assets')

</head>
<body class="@yield('body-class')" @if(langIsRTL(config('app.locale'))) dir="rtl" @endif>
