<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        مه گالری
    </title>

    <meta name=description content="{{\App\Helpers\getSetting('desc')}}">
    <meta name=keywords content="{{\App\Helpers\getSetting('keywords')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('css/theme.css')}}">
</head>
<body dir="rtl">
<header>

    <div id="preloader">
        <img src="{{asset('client/img/preloader.gif')}}" alt="">
    </div>
    <div id="top">
        <div class="row">
            <div class="col-md-4 ltr">

                <i class="fa fa-phone"></i>
                {{\App\Helpers\getSetting('tel')}}
            </div>
            <div class="col-md-4 ltr">
                <a href="https://api.whatsapp.com/send/?phone= {{\App\Helpers\getSetting('whatsup')}}&text=%D8%B3%D9%84%D8%A7%D9%85%D8%8C%20%D9%88%D9%82%D8%AA%20%D8%A8%D8%AE%DB%8C%D8%B1%D8%8C%20%D9%85%D9%86%20%D9%82%D8%B5%D8%AF%20%D8%A8%D8%B1%D9%82%D8%B1%D8%A7%D8%B1%DB%8C%20%D8%A7%D8%B1%D8%AA%D8%A8%D8%A7%D8%B7%20%D8%A8%D8%A7%20%D9%85%D9%87%E2%80%8C%DA%AF%D8%A7%D9%84%D8%B1%DB%8C%20%D8%B1%D8%A7%20%D8%AF%D8%A7%D8%B1%D9%85&app_absent=0">
                    <i class="fab fa-whatsapp"></i>
                    {{\App\Helpers\getSetting('whatsup')}}
                </a>
            </div>
            <div class="col-md-4">
                <i class="fa fa-dollar-sign"></i>
                طلای خام (گرم): {{number_format( (int) \App\Helpers\getSetting('price'))}} تومان
            </div>
        </div>
    </div>
    <div id="menu">
        <div class="item">
            <div class="toggle">
                <div class="fa fa-bars"></div>
            </div>
            <a data-toggle="modal" data-target=".bd-example-modal-sm">
                <i class="fa fa-search"></i>
            </a>
        </div>
        <div class="item text-center">
            <a href="{{route('welcome')}}">
                <img src="{{asset('client/img/mahlogo.svg')}}" id="logo" alt="">
            </a>
        </div>
        <div class="item text-right">
            <a href="{{route('card.show')}}">
                <span class="badge badge-success badge-pill" id="card-count">@if (count(unserialize(session('card',serialize([])))) > 0)
                    {{count(unserialize(session('card')))}}
                @endif</span>
                <i class="fa fa-shopping-bag"></i>
                <span>
                 سبد خرید
           </span>
            </a>
            @if (Auth::guard('customer')->check())
                <a href="{{route('customer')}}">
                    <i class="fa fa-user"></i>
                    <span>
                پروفایل
            </span>
            @else
            <a href="{{route('sign')}}">
                <i class="fa fa-user"></i>
                <span>
                ثبت نام یا ورود
            </span>
            @endif
            </a>
        </div>
    </div>
    <nav id="main-nav">
        <ul>
            <li><a href="/">{{config('app.name')}}</a></li>
            {!! App\Helpers\showCats() !!}
            {!! \App\Helpers\MenuShowByName('menu') !!}
        </ul>
    </nav>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <form action="{{route('search')}}" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">جستجو در مه‌گالری</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="search" name="q" placeholder="جستجو..." class="form-control" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-sm btn-warning"> جستجو </button>
                </div>
            </form>
        </div>
    </div>
</header>
@yield('content')
<footer class="wow fadeInUp">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-6">
                <h3>
                    مه گالری
                </h3>
                <ul class="border-right-0">
{{--                    @foreach(\Xmen\StarterKit\Models\Category::whereId(\App\Helpers\getSetting('footer-sec1'))->first()->posts as $p)--}}
{{--                    <li>--}}
{{--                        <a href="{{route('n.show',$p->slug)}}">--}}
{{--                            {{$p->title}}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    @endforeach--}}
                </ul>
            </div>
            <div class="col-lg-4 col-6">
                <h3>
{{--                    {{\Xmen\StarterKit\Models\Category::whereId(\App\Helpers\getSetting('footer-sec2'))->first()->name}}--}}
                </h3>
                <ul>
{{--                    @foreach(\Xmen\StarterKit\Models\Category::whereId(\App\Helpers\getSetting('footer-sec2'))->first()->posts as $p)--}}
{{--                        <li>--}}
{{--                            <a href="{{route('n.show',$p->slug)}}">--}}
{{--                                {{$p->title}}--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    @endforeach--}}
                </ul>
            </div>
            <div class="col-lg-4 col-12 text-center">
                <div class="p-3"></div>
                {!! \App\Helpers\getSetting('footer-sec3') !!}
            </div>
            <div class="col-lg-12">
                <hr>
                <div class="p-4 text-center">
                    {{\App\Helpers\getSetting('footer-copyright')}}
                </div>
            </div>
        </div>
    </div>
</footer>
<a id="whatsapp" target="_blank"
   href="https://api.whatsapp.com/send/?phone= {{\App\Helpers\getSetting('whatsup2')}}&text=%D8%B3%D9%84%D8%A7%D9%85%D8%8C%20%D9%88%D9%82%D8%AA%20%D8%A8%D8%AE%DB%8C%D8%B1%D8%8C%20%D9%85%D9%86%20%D9%85%DB%8C%E2%80%8C%D8%AE%D9%88%D8%A7%D9%87%D9%85%20%D9%82%D8%B5%D8%AF%20%D8%A8%D8%B1%D9%82%D8%B1%D8%A7%D8%B1%DB%8C%20%D8%A7%D8%B1%D8%AA%D8%A8%D8%A7%D8%B7%20%D8%A8%D8%A7%20%D9%85%D9%87%E2%80%8C%DA%AF%D8%A7%D9%84%D8%B1%DB%8C%20%D8%B1%D8%A7%20%D8%AF%D8%A7%D8%B1%D9%85&app_absent=0">
    <i class="fab fa-whatsapp"></i>
</a>
<input type="hidden" id="card-url" value="{{route('card.add','')}}"/>
<script src="{{asset('client/js/wow.min.js')}}"></script>
<script src="{{asset('js/theme.js')}}" defer></script>
</body>
</html>
