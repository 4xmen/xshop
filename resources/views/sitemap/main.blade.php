@php('<\?xml version="1.0" encoding="UTF-8"\?>')
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{route('sitemap.products')}}</loc>
        <lastmod>{{ \App\Models\Product::orderBy('updated_at','desc')->first()->updated_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{route('sitemap.cats')}}</loc>
        <lastmod>{{ \App\Models\Cat::orderBy('updated_at','desc')->first()->updated_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{route('sitemap.posts')}}</loc>
        <lastmod>{{ \Xmen\StarterKit\Models\Post::orderBy('updated_at','desc')->first()->updated_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
</sitemapindex>
