<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ asset('vendor/starter-kit/js/manifest.js') }}"  ></script>
    <script src="{{ asset('vendor/starter-kit/js/vendor.js') }}" defer  ></script>
    <script src="{{ asset('vendor/starter-kit/js/app.js') }}"  defer ></script>
    <script>
        @php
            $lang = \App\Models\Xlang::where('is_default',true)->first();
        @endphp
        var isRtl = false;
        @if($lang !== null && $lang->rtl)
            isRtl = true;
        @endif
    </script>
    @yield('header-content')
<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page_title', '') {{config('app.name', 'Laravel')}} </title>

    <!-- Styles -->

    <link href="{{ asset('vendor/starter-kit/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @foreach(\StarterKit::allStyles() as $name => $path)
        <link rel="stylesheet" href="/styles/{{ $name }}">
    @endforeach

</head>
<body>

@include('starter-kit::component.navbar')
<div id="wrapper">
    <div id="app">
        <div id="top-menu">
            <div class="row">
                <form action="" class="col-md-9">
                    <input type="search" value="" placeholder="{{__("Search in all panel")}}" class="form-control"/>
                </form>
                <div class="col-md-3">
                    <div class="m-2 float-start">
                        {{__("Welcome")}}: {{auth()->user()->name}}
                    </div>
                </div>
            </div>
        </div>
        <main class="py-4">
            <div class="container">
                @include('admin.component.breadcrump')
            </div>
            @yield('content')
        </main>
    </div>
    @yield('js-content')
</div>
<div id="preloader">
    <i class="fas fa-spinner fa fa-spinner fa-spin"></i>
</div>
<!-- Scripts -->

<script src="{{asset('js/editor/ckeditor.js')}}"></script>

@foreach (\StarterKit::allScripts() as $name => $path)
    @if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://']))
        <script src="{!! $path !!}"></script>
    @else
        <script src="/scripts/{{ $name }}"></script>
    @endif
@endforeach
<script src="{{ asset('js/app.js') }}" ></script>
<script type="text/javascript">
    var xupload = "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}";
    var tagsearch = "{{route('admin.ckeditor.tagsearch','')}}";
</script>
@yield('js-content')
@include('starter-kit::component.lang')
<script defer >
    window.addEventListener('load', (event) => {
        setTimeout(function () {
            window.StarterKit.boot();
        },100);
    });

</script>

</body>
</html>
