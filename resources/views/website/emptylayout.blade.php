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
    <title>
        @yield('title')
        {{config('app.name')}}
    </title>
    <link rel="stylesheet" href="{{asset('css/theme.css')}}">
</head>
<body>

<div id="preloader">
    <img src="{{asset('images/preloader.gif')}}" alt="">
</div>

<div id="main-container" class="container">
    <div id="app">
        @yield('content')
    </div>
</div>
<script src="{{asset('js/theme.js')}}" defer></script>
@include('component.lang')
</body>
</html>
