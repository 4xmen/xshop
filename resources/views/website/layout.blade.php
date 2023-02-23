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
    {!! \App\Helpers\remTitle( SEO::generate()) !!}

        <title>
            @yield('title')
            {{config('app.name')}}
        </title>
    <link rel="stylesheet" href="{{asset('css/theme.css')}}">

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
    <div class="tvdd" role="img" aria-label="Three intersecting rings of twelve pulsing dots that never collide">
        <div class="tvdd__ring">
            <div class="tvdd__ring-dots">
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
            </div>
        </div>
        <div class="tvdd__ring">
            <div class="tvdd__ring-dots">
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
            </div>
        </div>
        <div class="tvdd__ring">
            <div class="tvdd__ring-dots">
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
                <div class="tvdd__ring-dot"></div>
            </div>
        </div>
    </div>
</div>
<a id="go-top" href="#">
    <i class="fa fa-angle-up"></i>
</a>
<section id="top-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 text-start">
                <div class='marquee'>
                    <div class="row mt-2 pt-1" >
                        <a class="col" href="tel:{{\App\Helpers\getSetting('tel')}}">
                            <i class="fa fa-phone-alt"></i>
                            {{\App\Helpers\getSetting('tel')}}
                        </a>
                        <a class="col" href="mail:{{\App\Helpers\getSetting('email')}}">
                            <i class="fa fa-envelope"></i>
                            {{\App\Helpers\getSetting('email')}}
                        </a>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-6">
                <div class="input-group flex-nowrap" style="margin-top: 1em;">
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
                <a type="button" class="btn btn-primary position-relative" href="{{route('card.show')}}">
                    <i class="icofont-shopping-cart"></i>
                    سبد خرید
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                        <b id="card-count">
                            {{\App\Helpers\cardCount()}}
                        </b>
                    </span>
                </a>
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

@include('website.component.navbar')

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
