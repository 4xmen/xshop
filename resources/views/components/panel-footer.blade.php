@yield('js-content')
<script type="text/javascript">
    var xupload = "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}";
    window.routesList = @json(getAdminRoutes());
</script>
</body>
</html>
