@yield('js-content')
<script type="text/javascript">
    var xupload = "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}";
    var website_bg = "{{gfx()['background']}}";
    var website_text_color = "{{gfx()['text']}}";
    var website_font = "{{gfx()['font']}}";
    window.routesList = @json(getAdminRoutes());
</script>
@include('components.translates')
</body>
</html>
