@include('components.panel-header')
<div id="panel-preloader">
    <div class="loader"></div>
</div>
<div id="app">

    <input type="hidden" id="panel-dir" @if(langIsRTL(config('app.locale'))) value="rtl" @else value="ltr" @endif>

    @include('components.panel-top-navbar')

    <div>
        <div id="panel">
            <aside>
                @include('components.panel-side-navbar')
            </aside>
            <div id="sidebar-panel"></div>
            <main class="py-3 px-3">
                @include('components.panel-breadcrumb')
                @yield('content')
            </main>
        </div>
    </div>
</div>
@yield('js-content')
@include('components.panel-footer')
