<!doctype html>
<html lang="{{config('app.locale')}}" @if(langIsRTL(config('app.locale'))) dir="rtl" @else dir="ltr" @endif >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
    </title>

    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/dist/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{ route('theme.variable.css') }}">
    @vite(['resources/sass/client.scss', 'resources/js/client.js'])

    @yield('custom-head')

{{--    WIP rtl or ltr--}}
    @if(isset($breadcrumb))
{!! markUpBreadcrumbList($breadcrumb) !!}
    @endif
    @if(isset($post))
{!! $post->markup() !!}
    @endif
    @if(isset($product))
{!! $product->markup() !!}
    @endif
</head>
<body @yield('body-attr')>

@php($preloader = hasPart('preloader'))

<div id="website-preloader">
    @if($preloader != null)
        @include($preloader->getBlade())
    @endif
</div>
<div id="app">
@foreach(getParts('floats') as $part)
    @php($p = $part->getBladeWithData())
    @include($p['blade'],['data' => $p['data']])
@endforeach
