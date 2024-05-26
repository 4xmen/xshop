@include('components.panel-header')
<div id="app">

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
@include('components.panel-footer')
