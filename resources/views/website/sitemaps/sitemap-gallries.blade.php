@cache('sitemap_gallery'. cacheNumber(), 3600)
{{--update every 1 hour--}}
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"

         xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"

         xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @if(\App\Models\Gallery::count() > 0)

        <url>
            <loc>{{route('client.galleries')}}</loc>
            <lastmod>{{\App\Models\Gallery::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endif
    @foreach(\App\Models\Gallery::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)

        <url>
            <loc>{{route('client.gallery',$item->slug)}}</loc>
            <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach
    @if(config('app.xlang.active'))
        @foreach(\App\Models\XLang::where('is_default',0)->pluck('tag')->toArray() as $lang)

            @php(app()->setLocale($lang))
            @if(\App\Models\Gallery::count() > 0)

                <url>
                    <loc>{{route('client.galleries')}}/{{$lang}}</loc>
                    <lastmod>{{\App\Models\Gallery::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.7</priority>
                </url>
            @endif
            @foreach(\App\Models\Gallery::where('status',1)->whereLocale('title',$lang)->orderBy('id')->get(['slug','updated_at','title']) as $item)

                    <url>
                        <loc>{{$item->webUrl()}}</loc>
                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
                        <changefreq>weekly</changefreq>
                        <priority>0.5</priority>
                    </url>
            @endforeach
        @endforeach
    @endif

</urlset>
@endcache
