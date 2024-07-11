@if(langIsRTL(config('app.locale')))
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/dist/css/bootstrap.rtl.min.css')}}">
@else
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/dist/css/bootstrap.min.css')}}">
@endif

@if(config('app.debug') && !config('app.deployed'))
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@else
    <link rel="stylesheet" href="{{asset('build/assets/app-B_xQQxAx.css')}}">
    <script src="{{asset('build/assets/app-1AxZ3O2-.js')}}" defer type="module"></script>
@endif

<script src="{{asset('assets/vendor/editor/ckeditor.js')}}"></script>
