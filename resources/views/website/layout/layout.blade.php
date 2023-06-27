@include('website.component.header')

<div id="preloader">
    <img src="{{asset('images/preloader.gif')}}" alt="">
</div>

<div class="@yield('body-class')">
    <div id="app">
        @yield('content')
    </div>
</div>

@include('website.component.footer')
