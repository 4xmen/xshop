@include('website.component.header')

<div id="main-container" class="@yield('body-class')">
    <div id="app">
        @yield('content')
    </div>
</div>

@include('website.component.footer')
