<!doctype html>
<html lang="{{app()->getLocale()}}" @if(langIsRTL(app()->getLocale())) dir="rtl" @else dir="ltr" @endif @if(gfx()['dark'] == 1) data-bs-theme="dark" @endif >
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="{{gfx()['primary']}}"/>
    @if(config('app.demo') || isset($noIndex))
        <meta name="robots" content="noindex">
    @else
        <meta name="robots" content="follow,index">
    @endif

    <meta name="generator" content="xShop; version={{config('app.version')}}">
    {{--  Please don't modify or remove generator --}}

    <title>
        @yield('title')
    </title>

    @if(langIsRTL(app()->getLocale()))
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/dist/css/bootstrap.rtl.min.css')}}">
    @else
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/dist/css/bootstrap.min.css')}}">
    @endif

    <link rel="stylesheet" href="{{ route('theme.variable.css') }}">
    @vite(['resources/sass/client.scss', 'resources/js/client.js'])

    @yield('custom-head')

{{--    WIP rtl or ltr--}}

{{--    seo  --}}
    <meta property="og:site_name" content="{{config('app.name')}}" />
    <meta property="og:locale" content="{{app()->getLocale()}}">
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
        <meta name="description" content="{{Str::limit($post->subtitle,150)}}">
        <meta name="keywords" content="{{$post->tagsList()}}">

        @if(\Illuminate\Support\Str::isUrl($post->canonical) )
            <link rel="canonical" href="{{$post->canonical}}" />
        @endif

    @elseif(isset($product))
{!! $product->markup() !!}
        <meta property="og:title" content="{{$product->name}}"/>
        <meta property="og:description" content="{{$product->seoDesc()}}"/>
        <meta property="og:image" content="{{$product->imgUrl()}}"/>
        <meta property="og:url" content="{{$product->webUrl()}}"/>
        <meta name="description" content="{{$product->seoDesc()}}">
        <meta name="keywords" content="{{$product->tagsList()}}">
        <meta name="product_id" content="{{$product->id}}">
        <meta name="product_name" content="{{$product->name}}">
        <meta name="product_price" content="{{$product->price}}">
        <meta name="product_old_price" content="{{$product->oldPricePure()}}">

        <meta property="product:price:amount" content="{{$product->price}}">
        <meta property="product:price:currency" content="{{config('app.currency.code')}}">

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:image" content="{{$product->imgUrl()}}" />
        <meta name="twitter:description" content="{{$product->seoDesc()}}" />


        <meta name="availability" content="{{strtolower(str_replace('_','',$product->status))}}">
        <meta name="guarantee" content="{{getSetting('guarantee')}}">

        @if(\Illuminate\Support\Str::isUrl($product->canonical) )
            <link rel="canonical" href="{{$product->canonical}}" />
        @endif

    @elseif(isset($group))
        @if(\Illuminate\Support\Str::isUrl($group->canonical) )
            <link rel="canonical" href="{{$group->canonical}}" />
        @endif
    @elseif(isset($category))
        @if(\Illuminate\Support\Str::isUrl($category->canonical) )
            <link rel="canonical" href="{{$category->canonical}}" />
        @endif
        @if(request()->has('meta') || request()->has('sort'))
            <link rel="canonical" href="{{$category->webUrl()}}" />
        @endif
    @elseif(isset($clip))
{!! $clip->markup() !!}
        <meta property="og:title" content="{{$clip->title}}" />
        <meta property="og:description" content="{{Str::limit(strip_tags($clip->body),150)}}" />
        <meta property="og:type" content="video.other" />
        <meta property="og:url" content="{{$clip->webUrl()}}" />
        <meta property="og:image" content="{{$clip->imgUrl()}}" />
        <meta property="og:video" content="{{$clip->fileUrl()}}" />
        <meta property="og:video:type" content="video/mp4" />
        <meta name="description" content="{{getSetting('desc')}}">
        <meta name="keywords" content="{{$clip->tagsList()}}">
{{--        <meta property="og:video:width" content="1280" />--}}
{{--        <meta property="og:video:height" content="720" />--}}

    @elseif(isset($gallery))
        <meta property="og:title" content="{{$gallery->title}}">
        <meta property="og:description" content="{{Str::limit(strip_tags($gallery->body),150)}}" />
        <meta property="og:image" content="{{$gallery->imgUrl()}}">
        <meta property="og:image:alt" content="{{$gallery->slug}}">
        <meta property="og:url" content="{{$gallery->webUrl()}}">
        <meta property="og:type" content="website">
        <meta name="description" content="{{getSetting('desc')}}">
        <meta name="keywords" content="{{getSetting('keyword')}}">
    @else
        <meta name="description" content="{{getSetting('desc')}}">
        <meta name="keywords" content="{{getSetting('keyword')}}">
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
