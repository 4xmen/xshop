<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="{{\App\Helpers\getSetting('color')}}"/>
    <meta name="keywords" content="{{\App\Helpers\getSetting('keywords')}}">
    <meta name="description" content="{{\App\Helpers\getSetting('desc')}}">
    <meta name="robots" content="follow,index">
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('favicon/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('favicon/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('favicon/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('favicon/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('favicon/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('favicon/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('favicon/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('favicon/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.ong')}}">
    <link rel="manifest" href="{{asset('favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    {!! \App\Helpers\remTitle( SEO::generate()) !!}

        {!! \App\Helpers\getSetting('site_webmaster_google') !!}
        <title>
            @yield('title')
            {{config('app.name')}}
        </title>
    <link rel="stylesheet" href="{{asset('css/theme.css')}}">

    @yield('metas')
</head>
<body>

@if(trim(\App\Helpers\getSetting('soc_wp')) != '')
    <a class="my-float"
       target="_blank"
       href="https://api.whatsapp.com/send/?phone={{urlencode(\App\Helpers\getSetting('soc_wp'))}}&text=%D8%A8%D8%A7%20%D8%B3%D9%84%D8%A7%D9%85%0A%D8%A7%D8%B2%20%D8%B3%D8%A7%DB%8C%D8%AA%20%D8%A8%D8%B1%D8%A7%DB%8C%20%D8%B3%D9%81%D8%A7%D8%B1%D8%B4%20%D9%88%20%D9%BE%D8%B4%D8%AA%DB%8C%D8%A8%D8%A7%D9%86%DB%8C%20%D8%AA%D9%85%D8%A7%D8%B3%20%D9%85%DB%8C%DA%AF%DB%8C%D8%B1%D9%85&app_absent=0">
        <i class="fab fa-whatsapp"></i>
    </a>
@endif
<div id="preloader">
    <img src="{{asset('images/preloader.gif')}}" alt="">
</div>
<a id="go-top" href="#">
    <i class="fa fa-angle-up"></i>
</a>
<section id="top-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <a href="{{route('welcome')}}" class="navbar-brand">
                    <img src="{{asset('images/logo.png')}}" class="logo" alt="">
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <br>
                <div class="input-group flex-nowrap">
                    <input type="text" id="searching" data-url="{{route('search')}}"
                           data-ajax="{{route('search.ajax')}}" class="form-control" placeholder="جستجو در محصولات..."
                           aria-label="search"
                           aria-describedby="addon-wrapping">
                                <span class="input-group-text" id="addon-wrapping">
                                    <i class="icofont-search bg-custom2 text-light rounded-circle"></i>
                                </span>
                </div>
            </div>
            <div class="col-lg-4 text-end col-md-6">
                <br>
                <a type="button" class="btn btn-primary position-relative" href="{{route('card.show')}}">
                    <i class="icofont-shopping-cart"></i>
                    سبد خرید
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                        <b id="card-count">
                            {{\App\Helpers\cardCount()}}
                        </b>
                    </span>
                </a>
                &nbsp;
                @if(Auth::guard('customer')->check())
                    <div class="btn btn-outline-primary">
                        <a href="{{route('customer')}}">
                            {{__("Profile")}}
                        </a>
                    </div>
                @else
                    <div class="btn btn-outline-primary">
                        <a href="{{route('sign')}}">
                            <i class="icofont-user"></i>
                            {{__("Login / Register")}}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<nav id="main-nav">
    <ul>
        <li><a href="/">خانه</a></li>
        {!! \App\Helpers\showCats() !!}
        {!! \App\Helpers\MenuShowByName('menu')  !!}
    </ul>
</nav>
<section id="top">
    <div>
        <div class="main-wrapper">
            <nav class="navbarx">
                <div class="brand-and-icon">
{{--                    <button type="button" class="navbarx-toggler">--}}
{{--                        <i class="fas fa-bars"></i>--}}
{{--                    </button>--}}
                    <div class="toggle">
                        <i class="fas fa-bars"></i>
                    </div>
                    <div>
                        <a href="{{route('welcome')}}" class="navbar-brand mobile-only">
                            <img src="{{asset('images/logo.png')}}" class="logo" alt="">
                        </a>
                    </div>
                </div>

                <div class="navbarx-collapse">
                    <ul class="navbarx-nav">
                        <li>
                            <a href="/">
                                {{__("Home")}}
                            </a>
                        </li>
                        @foreach(\App\Helpers\getMainCats() as $cat)
                            <li>
                                <a href="{{route('cat',$cat->slug)}}" class="menu-link">
                                    {{$cat->name}}
                                    <span class="drop-icon">
                                     <i class="fas fa-chevron-down"></i>
                                    </span>
                                </a>
                                <div class="sub-menu">
                                    <!-- item -->
                                    <div class="sub-menu-item">
                                        <h4>
                                            محصولات جدید
                                            {{$cat->name}}
                                        </h4>
                                        <ul>
                                            @foreach(\App\Helpers\getProductByCatQ($cat->id) as $p)
                                                <li>
                                                    <a href="{{route('product',$p->slug)}}">
                                                        {{$p->name}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- end of item -->
                                    <!-- item -->
                                    <div class="sub-menu-item">
                                        <h4> محصولات به تفکیک </h4>
                                        <ul>
                                            @foreach(\App\Helpers\getSubCats($cat->id) as $c)
                                                <li>
                                                    <a href="{{route('cat',$c->slug)}}">
                                                        {{$c->name}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- end of item -->
                                    <!-- item -->
                                    <div class="sub-menu-item">
                                        <b>
                                            {{mb_substr($cat->description,0,100)}}...
                                        </b>
                                        <br>
                                        <a href="{{route('cat',$cat->slug)}}" class="btn">همه
                                            محصولات {{$cat->name}} </a>
                                    </div>
                                    <!-- end of item -->
                                    <!-- item -->
                                    <div class="sub-menu-item">
                                        <img src="{{$cat->thumbUrl()}} " alt="{{$cat->name}}">
                                    </div>
                                    <!-- end of item -->
                                </div>
                            </li>
                        @endforeach

                        {!! \App\Helpers\MenuShowByName('menu')  !!}


                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div id="search-list">
        search
    </div>
</section>

<div id="main-container" class="@yield('body-class')">
    <div id="app">
        @yield('content')
    </div>
</div>

{{--<a id="card-info" @if(\App\Helpers\cardCount() == 0) style="display: none" @endif href="{{route('card.show')}}">--}}
{{--    <button type="button" class="btn btn-primary position-relative">--}}
{{--        <img src="{{asset('images/basket.svg')}}" class="basket-icon" alt="add to card">--}}
{{--        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">--}}
{{--            <b id="card-count">--}}
{{--                {{\App\Helpers\cardCount()}}--}}
{{--            </b>--}}
{{--        </span>--}}
{{--    </button>--}}
{{--</a>--}}
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <h3>
                    {{\App\Helpers\getSettingCategory('footer1')->name}}
                </h3>
                <ul>
                    @foreach(\App\Helpers\getSettingCategory('footer1')->posts as $p)
                        <li>
                            <a href="{{route('n.show',$p->slug)}}">
                                {{$p->title}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h3>
                    {{\App\Helpers\getSettingCategory('footer2')->name}}
                </h3>
                <ul>
                    @foreach(\App\Helpers\getSettingCategory('footer2')->posts as $p)
                        <li>
                            <a href="{{route('n.show',$p->slug)}}">
                                {{$p->title}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-3">
                <h3>
                    اطلاعات تماس
                </h3>
                <p class="text-secondary">
                    افراد گروه سوم از اهمیت به پایان رساندن آگاه هستند. آنها با تفکر منطقی، طرحی روشن ارائه می‌کنند. آنها نه تنها برای پایان دادن به پروژه‌ی خود در آینده برنامه ریزی می‌کنند، بلکه به تمام نتایج و عواقب اجرای آن برنامه هم می‌اندیشند. این افراد کسانی هستند که هنر به پایان رساندن را می‌دانند.
                </p>
            </div>
            <div class="col-md-3">
                <h3>
                    نمادها
                </h3>
                <div class="text-center namad">
                    {!! \App\Helpers\getSetting('footer3') !!}
                </div>
            </div>
            <div class="col-md-12 pb-4">
                <hr>
                <div class="p4 text-center social">
                    @if(trim(\App\Helpers\getSetting('soc_in')) != '')
                        <a target="_blank" href="{{\App\Helpers\getSetting('soc_in')}}">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if(trim(\App\Helpers\getSetting('soc_tg')) != '')
                        <a target="_blank" href="{{\App\Helpers\getSetting('soc_tg')}}">
                            <i class="fab fa-telegram"></i>
                        </a>
                    @endif
                    @if(trim(\App\Helpers\getSetting('soc_wp')) != '')
                        <a target="_blank"
                           href="https://api.whatsapp.com/send/?phone={{urlencode(\App\Helpers\getSetting('soc_wp'))}}&text=%D8%A8%D8%A7%20%D8%B3%D9%84%D8%A7%D9%85%0A%D8%A7%D8%B2%20%D8%B3%D8%A7%DB%8C%D8%AA%20%D8%A8%D8%B1%D8%A7%DB%8C%20%D8%B3%D9%81%D8%A7%D8%B1%D8%B4%20%D9%88%20%D9%BE%D8%B4%D8%AA%DB%8C%D8%A8%D8%A7%D9%86%DB%8C%20%D8%AA%D9%85%D8%A7%D8%B3%20%D9%85%DB%8C%DA%AF%DB%8C%D8%B1%D9%85&app_absent=0">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    @endif
                    @if(trim(\App\Helpers\getSetting('soc_tw')) != '')
                        <a target="_blank" href="{{\App\Helpers\getSetting('soc_tw')}}">
                            <i class="fab fa-twitter"></i>
                        </a>
                    @endif
                    @if(trim(\App\Helpers\getSetting('soc_yt')) != '')
                        <a target="_blank" href="{{\App\Helpers\getSetting('soc_yt')}}">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif
                </div>
                <hr>
                <div class="text-center text-black-50">
                    {{\App\Helpers\getSetting('copyright')}}
                    &copy; {{date('Y')}}
                </div>
            </div>
        </div>
    </div>
</footer>
<input type="hidden" id="fav-toggle" value="{{route('fav.toggle','')}}">
@yield('js-content')
<script src="{{asset('js/theme.js')}}" defer></script>
@include('component.lang')
</body>
</html>
