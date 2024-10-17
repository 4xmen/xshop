@cache('sitemap'. cacheNumber(),43200)
{{--update every 12 hours--}}
<sitemapindex xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"

              xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
              xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if(\App\Models\Product::count() > 0)

        <sitemap>
            <loc>{{route('sitemap.products')}}</loc>
            <lastmod>{{\App\Models\Product::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
        </sitemap>

    @endif

    @if(\App\Models\Post::count() > 0)

        <sitemap>
            <loc>{{route('sitemap.posts')}}</loc>
            <lastmod>{{\App\Models\Post::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
        </sitemap>

    @endif

    @if(\App\Models\Gallery::count() > 0)

        <sitemap>
            <loc>{{route('sitemap.galleries')}}</loc>
            <lastmod>{{\App\Models\Gallery::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
        </sitemap>

    @endif

    @if(\App\Models\Clip::count() > 0)

        <sitemap>
            <loc>{{route('sitemap.clips')}}</loc>
            <lastmod>{{\App\Models\Clip::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
        </sitemap>

    @endif

    @if(\App\Models\Attachment::count() > 0)

        <sitemap>
            <loc>{{route('sitemap.attachments')}}</loc>
            <lastmod>{{\App\Models\Attachment::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
        </sitemap>

    @endif
    @if(\App\Models\Group::count() > 0 || \App\Models\Category::count())

        <sitemap>
            <loc>{{route('sitemap.categories')}}</loc>
            @if($latestUpdate)
                <lastmod>{{ $latestUpdate->tz('UTC')->toAtomString() }}</lastmod>
            @else
                <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod> <!-- Fallback if there are no records -->
            @endif
        </sitemap>

    @endif

</sitemapindex>
@endcache
