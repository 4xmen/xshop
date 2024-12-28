@include('components.panel-header')
<div id="panel-preloader">
    <div class="loader"></div>
</div>
<div id="app">

    <input type="hidden" id="panel-dir" @if(langIsRTL(config('app.locale'))) value="rtl" @else value="ltr" @endif>

    @include('components.panel-top-navbar')

    <div>
        <div id="panel">
            @cache('navbar_panel'. cacheNumber())
            <aside>
                @include('components.panel-side-navbar')
            </aside>
            @endcache
            <div id="sidebar-panel"></div>
            <main class="py-3 px-3">
                @include('components.panel-breadcrumb')
                @yield('content')
            </main>
        </div>
    </div>
    @if(isset($item) && isset($item->attachs))
        <div id="attaching-form">
            <i class="ri-skip-down-line" id="attach-down" data-bs-toggle="tooltip"
               data-bs-placement="top"
               data-bs-custom-class="custom-tooltip"
               data-bs-title="{{__("Collapse attachment form")}}"></i>
            <div class="p-4">
                <h5>
                    {{__("Attachments")}}
                </h5>
                <fast-attaching
                    :attachments='@json($item->attachs)'
                    xlang="{{config('app.locale')}}"
                    upload-url="{{route('admin.attachment.attaching')}}"
                    detach-url="{{route('admin.attachment.detach','')}}/"
                    model="{{get_class($item)}}"
                    id="{{$item->id}}"
                ></fast-attaching>
            </div>
        </div>
    @endif
</div>
@yield('js-content')
@include('components.panel-footer')
