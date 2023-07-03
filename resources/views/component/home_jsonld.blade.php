@section('jsonld')
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "url": "{{config('app.url')}}",
            "name": "{{\SEOMeta::getTitle()}}",
            "author": {
                "@type": "Person",
                "name": "gold"
            },
            "description": "{{\SEOMeta::getTitle()}}"
            }
    </script>
@endsection
