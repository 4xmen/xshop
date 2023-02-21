@section('jsonld')
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "url": "https://shop.ir/",
            "name": "{{\SEOMeta::getTitle()}}",
            "author": {
                "@type": "Person",
                "name": "gold"
            },
            "description": "{{\SEOMeta::getTitle()}}"
            }
    </script>
@endsection
