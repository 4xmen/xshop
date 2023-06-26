<!doctype html>
<html lang="{{config('app.locale')}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="{{\App\Helpers\getSetting('color')}}"/>
    <meta name="keywords" content="{{\App\Helpers\getSetting('keywords')}}">
    <meta name="description" content="{{\App\Helpers\getSetting('desc')}}">
    <meta name="robots" content="follow,index">
    {!! \App\Helpers\remTitle( SEO::generate()) !!}

    <title>
        @yield('title')
        {{config('app.name')}}
    </title>
    <link rel="stylesheet" href="{{asset('css/theme.css')}}">

</head>
<body>
<!--header navbar-->
<nav class="up-nav col-12">
    <a href="{{url('/')}}">
        <img src="{{asset('images/logo.png')}}" class="rounded-0" alt="">
    </a>
</nav>
<!--header-->
<header id="header" class="mt-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-6 d-xl-none mb-2 ">
                <a href="#" class="btn btn-outline-light text-dark">
                    <i class="fa fa-search"></i>
                </a>
                <div class="btn btn-primary">
                    <i class="fa fa-basket-shopping"></i>
                    <b class="card-count">
                        {{\App\Helpers\cardCount()}}
                    </b>
                </div>
                @if(Auth::guard('customer')->check())
                    <a class="btn btn-outline-info" href="{{route('customer')}}">
                        <i class="ri-user-line"></i>
                    </a>
                @else
                    <a class="btn btn-outline-info" href="{{route('sign')}}">
                        <i class="ri-user-line"></i>
                    </a>
                @endif
            </div>
            <div class="col-xl-3 d-none d-xl-block">
                <div class="">

                    &nbsp;
                    <div class="btn btn-outline-info btn-icon">
                        <div class="icon">
                            <i class="ri-user-line"></i>
                            @if(Auth::guard('customer')->check())
                                <a href="{{route('customer')}}">
                                    {{__("Profile")}}
                                </a>
                            @else
                                <a href="{{route('sign')}}">
                                    <i class="icofont-user"></i>
                                    {{__("Login / Register")}}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 ">
                <div class="input-group">
                    <input type="text" id="searching" data-url="{{route('search')}}"
                           data-ajax="{{route('search.ajax')}}" class="form-control silver"
                           placeholder="جستجو در محصولات..."
                           aria-label="search"
                           aria-describedby="addon-wrapping">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2">
                        <i class="ri-search-line"></i>
                    </button>
                </div>
            </div>
            <div class="col-xl-3 text-end d-none d-xl-block">
                <div class="btn btn-outline-primary btn-icon">
                    <div class="icon">
                        <b class="card-count">
                            {{\App\Helpers\cardCount()}}
                            &nbsp;
                            <i class="ri-shopping-cart-line float-end"></i>
                        </b>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 d-none d-xl-block">
                <div class="btn btn-primary w-100 align-items-center justify-content-between d-flex" id="main-nav">
                    <i class="ri-menu-line float-start"></i>
                    همه محصولات
                    <i class="ri-arrow-drop-down-line float-end"></i>
                    @include('website.component.navbar')
                </div>
            </div>
            <div class="col-xl-6 ">
                <div class="d-flex justify-content-around">
                    {!! \App\Helpers\MenuShowByName('menu')  !!}
                </div>
            </div>
            <div class="col-xl-3 text-center">
                <div>
                    <a class="small">
                        تلفن‌ تماس
                    </a>
                    <br>
                    <a href="tel:{{\App\Helpers\getSetting('tel')}}" class="btn btn-secondary text-dark">
                        {{\App\Helpers\getSetting('tel')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<!--header-->
<div id="search-list"></div>


