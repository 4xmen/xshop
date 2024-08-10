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

{{--    seo  --}}
    <meta property="og:site_name" content="{{config('app.name')}}" />
    <meta property="og:locale" content="{{config('app.locale')}}">
    @if(isset($breadcrumb))
{!! markUpBreadcrumbList($breadcrumb) !!}
    @endif
    @if(isset($post))
{!! $post->markup() !!}
        <meta property="og:title" content="{{$post->title}}" />
        <meta property="og:description" content="{{$post->subtitle}}" />
        <meta property="og:image" content="{{$post->imgUrl()}}" />
        <meta property="og:url" content="{{$post->webUrl()}}" />
        <meta property="og:type" content="article" />
    @endif
    @if(isset($product))
{!! $product->markup() !!}
        <meta property="og:title" content="{{$product->name}}"/>
        <meta property="og:description" content="{{$product->seoDesc()}}"/>
        <meta property="og:image" content="{{$product->imgUrl()}}"/>
        <meta property="og:url" content="{{$product->webUrl()}}"/>
    @endif
    @if(isset($clip))
{!! $clip->markup() !!}
        <meta property="og:title" content="{{$clip->title}}" />
        <meta property="og:description" content="{{Str::limit(strip_tags($clip->body),12)}}" />
        <meta property="og:type" content="video.other" />
        <meta property="og:url" content="{{$clip->webUrl()}}" />
        <meta property="og:image" content="{{$clip->imgUrl()}}" />
        <meta property="og:video" content="{{$clip->fileUrl()}}" />
        <meta property="og:video:type" content="video/mp4" />
{{--        <meta property="og:video:width" content="1280" />--}}
{{--        <meta property="og:video:height" content="720" />--}}

    @endif
    @if(isset($gallery))
        <meta property="og:title" content="{{$gallery->title}}">
        <meta property="og:description" content="{{Str::limit(strip_tags($gallery->body),12)}}" />
        <meta property="og:image" content="{{$gallery->imgUrl()}}">
        <meta property="og:image:alt" content="{{$gallery->slug}}">
        <meta property="og:url" content="{{$gallery->webUrl()}}">
        <meta property="og:type" content="website">
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
