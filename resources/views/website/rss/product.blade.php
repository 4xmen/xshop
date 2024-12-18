@cache('sitemap_attach'. cacheNumber(), 3600)
<rss version="2.0">
    <channel>
        <title>{{config('app.name')}}</title>
        <link>{{ url('/') }}</link>
        <description>{{getSetting('description')}}</description>
        <language>{{config('app.locale')}}</language>
        <pubDate>{{ \Carbon\Carbon::now()->toRssString() }}</pubDate>

        @foreach($products as $product)
            <item>
                <title><![CDATA[{{ $product->name }}]]></title>
                <link>{{ $product->webUrl()  }}</link>
                <description><![CDATA[{{ $product->excerpt }}]]></description>
                <pubDate>{{ $product->created_at->toRssString() }}</pubDate>
                <guid>{{ $product->webUrl()  }}</guid>
            </item>
        @endforeach
    </channel>
</rss>
@endcache
