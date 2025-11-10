@cache('sitemap_products'. cacheNumber(), 3600)
{{--update every 1 hour--}}
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"

        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"

        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @if(\App\Helpers\General::getSetting('sitemap_group'))
        @foreach(\App\Models\Group::orderBy('id')->get(['slug','updated_at']) as $item)

            <url>
                <loc>{{route('client.group',$item->slug)}}</loc>
                <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.5</priority>
            </url>
        @endforeach
    @endif
    @if(\App\Helpers\General::getSetting('sitemap_category'))
        @foreach(\App\Models\Category::orderBy('id')->get(['slug','updated_at']) as $item)

            <url>
                <loc>{{route('client.category',$item->slug)}}</loc>
                <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.5</priority>
            </url>
        @endforeach
    @endif
    @if(\App\Helpers\General::getSetting('sitemap_creator'))
        @foreach(\App\Models\Creator::orderBy('id')->get(['slug','updated_at']) as $item)

            <url>
                <loc>{{route('client.creator',$item->slug)}}</loc>
                <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.5</priority>
            </url>
        @endforeach
    @endif

    @if(config('app.xlang.active') && \App\Helpers\General::getSetting('sitemap_multi_lang'))
        @foreach(\App\Models\XLang::where('is_default',0)->pluck('tag')->toArray() as $lang)

            @php(app()->setLocale($lang))
            @if(\App\Helpers\General::getSetting('sitemap_group'))
                @foreach(\App\Models\Group::whereLocale('name',$lang)->orderBy('id')->get(['slug','updated_at','name']) as $item)

                    <url>
                        <loc>{{$item->webUrl()}}</loc>
                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
                        <changefreq>weekly</changefreq>
                        <priority>0.5</priority>
                    </url>
                @endforeach
            @endif
            @if(\App\Helpers\General::getSetting('sitemap_category'))
                @foreach(\App\Models\Category::whereLocale('name',$lang)->orderBy('id')->get(['slug','updated_at','name']) as $item)

                    <url>
                        <loc>{{$item->webUrl()}}</loc>
                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
                        <changefreq>weekly</changefreq>
                        <priority>0.5</priority>
                    </url>
                @endforeach
            @endif
            @if(\App\Helpers\General::getSetting('sitemap_creator'))
                @foreach(\App\Models\Creator::whereLocale('name',$lang)->orderBy('id')->get(['slug','updated_at','name']) as $item)

                    <url>
                        <loc>{{$item->webUrl()}}</loc>
                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
                        <changefreq>weekly</changefreq>
                        <priority>0.5</priority>
                    </url>
                @endforeach
            @endif
        @endforeach
    @endif

</urlset>
@endcache
