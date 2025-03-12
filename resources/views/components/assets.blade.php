@if(langIsRTL(config('app.locale')))
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/dist/css/bootstrap.rtl.min.css')}}">
@else
    <link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/dist/css/bootstrap.min.css')}}">
@endif

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/panel/raw.js'])

<script src="{{asset('assets/vendor/editor/ckeditor.js')}}"></script>
