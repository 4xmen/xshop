@yield('js-content')
<div id="iframe-modal">
    <div class="container">
        <iframe href="#"></iframe>
    </div>
</div>
<script type="text/javascript">
    var xupload = "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}";
    var switchThemeUrl = "{{route('admin.user.switch-theme')}}";
    var website_bg = "{{gfx()['background']}}";
    var website_text_color = "{{gfx()['text']}}";
    var website_font = "{{gfx()['font']}}";
    window.routesList = @json(getAdminRoutes());
</script>
@include('components.translates')
</body>
</html>
