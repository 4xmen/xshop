@section('jsonld')
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "url": "{{config('app.url')}}",
            "name": "{{\SEOMeta::getTitle()}}",
            "author": {
                "@type": "Person",
                "name": "{{config('app.name')}}",
            },
            "description": "{{\SEOMeta::getTitle()}}"
            }
    </script>
@endsection
