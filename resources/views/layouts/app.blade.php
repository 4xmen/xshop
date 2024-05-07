@include('components.panel-header')
<div id="app">

    @include('components.panel-top-navbar')

    <div>
        <div id="panel">
            <aside>
                @include('components.panel-side-navbar')
            </aside>
            <div id="sidebar-panel"></div>
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>
</div>
@include('components.panel-footer')
