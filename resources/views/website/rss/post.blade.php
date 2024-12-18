@cache('sitemap_attach'. cacheNumber(), 3600)
<rss version="2.0">
    <channel>
        <title>{{config('app.name')}}</title>
        <link>{{ url('/') }}</link>
        <description>{{getSetting('description')}}</description>
        <language>{{config('app.locale')}}</language>
        <pubDate>{{ \Carbon\Carbon::now()->toRssString() }}</pubDate>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[{{ $post->title }}]]></title>
                <link>{{ $post->webUrl()  }}</link>
                <description><![CDATA[{{ $post->subtitle }}]]></description>
                <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
                <guid>{{ $post->webUrl()  }}</guid>
            </item>
        @endforeach
    </channel>
</rss>
@endcache
