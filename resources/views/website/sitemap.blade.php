<? xml version = "1.0" encoding = "utf-8" ?>
<? xml - stylesheet type = "text/xsl" href = "http://4xmen.ir/wp-content/plugins/google-sitemap-plugin/sitemap.xsl" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @if(\App\Models\Product::count() > 0)

        <url>
            <loc>{{route('client.products')}}</loc>
            <lastmod>{{\App\Models\Product::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>daily</changefreq>
            <priority>1</priority>
        </url>
    @endif
    @if(\App\Models\Post::count() > 0)

        <url>
            <loc>{{route('client.posts')}}</loc>
            <lastmod>{{\App\Models\Post::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1</priority>
        </url>
    @endif
    @if(\App\Models\Gallery::count() > 0)

        <url>
            <loc>{{route('client.galleries')}}</loc>
            <lastmod>{{\App\Models\Gallery::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>2</priority>
        </url>
    @endif
    @if(\App\Models\Attachment::count() > 0)

        <url>
            <loc>{{route('client.attachments')}}</loc>
            <lastmod>{{\App\Models\Attachment::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>2</priority>
        </url>
    @endif
    @if(\App\Models\Clip::count() > 0)

        <url>
            <loc>{{route('client.clips')}}</loc>
            <lastmod>{{\App\Models\Clip::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>2</priority>
        </url>
    @endif
    @foreach(\App\Models\Product::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)

        <url>
            <loc>{{route('client.product',$item->slug)}}</loc>
            <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>3</priority>
        </url>
    @endforeach
    @foreach(\App\Models\Post::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)

        <url>
            <loc>{{route('client.post',$item->slug)}}</loc>
            <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>3</priority>
        </url>
    @endforeach
    @foreach(\App\Models\Clip::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)

        <url>
            <loc>{{route('client.clip',$item->slug)}}</loc>
            <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>3</priority>
        </url>
    @endforeach
    @foreach(\App\Models\Gallery::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)

        <url>
            <loc>{{route('client.gallery',$item->slug)}}</loc>
            <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>3</priority>
        </url>
    @endforeach
    @foreach(\App\Models\Attachment::where('is_fillable',1)->orderBy('id')->get(['slug','updated_at']) as $item)

        <url>
            <loc>{{route('client.attachment',$item->slug)}}</loc>
            <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>3</priority>
        </url>
    @endforeach
    @if(config('app.xlang.active'))
        @foreach(\App\Models\XLang::where('is_default',0)->pluck('tag')->toArray() as $lang)
{{--     WIP multi lang       --}}
{{--                @if(\App\Models\Product::count() > 0)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.products')}}</loc>--}}
{{--                        <lastmod>{{\App\Models\Product::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>daily</changefreq>--}}
{{--                        <priority>1</priority>--}}
{{--                    </url>--}}
{{--                @endif--}}
{{--                @if(\App\Models\Post::count() > 0)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.posts')}}</loc>--}}
{{--                        <lastmod>{{\App\Models\Post::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>1</priority>--}}
{{--                    </url>--}}
{{--                @endif--}}
{{--                @if(\App\Models\Gallery::count() > 0)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.galleries')}}</loc>--}}
{{--                        <lastmod>{{\App\Models\Gallery::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>2</priority>--}}
{{--                    </url>--}}
{{--                @endif--}}
{{--                @if(\App\Models\Attachment::count() > 0)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.attachments')}}</loc>--}}
{{--                        <lastmod>{{\App\Models\Attachment::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>2</priority>--}}
{{--                    </url>--}}
{{--                @endif--}}
{{--                @if(\App\Models\Clip::count() > 0)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.clips')}}</loc>--}}
{{--                        <lastmod>{{\App\Models\Clip::orderByDesc('updated_at')->first()->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>2</priority>--}}
{{--                    </url>--}}
{{--                @endif--}}
{{--                @foreach(\App\Models\Product::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.product',$item->slug)}}</loc>--}}
{{--                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>3</priority>--}}
{{--                    </url>--}}
{{--                @endforeach--}}
{{--                @foreach(\App\Models\Post::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.post',$item->slug)}}</loc>--}}
{{--                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>3</priority>--}}
{{--                    </url>--}}
{{--                @endforeach--}}
{{--                @foreach(\App\Models\Clip::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.clip',$item->slug)}}</loc>--}}
{{--                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>3</priority>--}}
{{--                    </url>--}}
{{--                @endforeach--}}
{{--                @foreach(\App\Models\Gallery::where('status',1)->orderBy('id')->get(['slug','updated_at']) as $item)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.gallery',$item->slug)}}</loc>--}}
{{--                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>3</priority>--}}
{{--                    </url>--}}
{{--                @endforeach--}}
{{--                @foreach(\App\Models\Attachment::where('is_fillable',1)->orderBy('id')->get(['slug','updated_at']) as $item)--}}

{{--                    <url>--}}
{{--                        <loc>{{route('client.attachment',$item->slug)}}</loc>--}}
{{--                        <lastmod>{{$item->updated_at->tz('UTC')->toAtomString()}}</lastmod>--}}
{{--                        <changefreq>weekly</changefreq>--}}
{{--                        <priority>3</priority>--}}
{{--                    </url>--}}
{{--                @endforeach--}}
        @endforeach
    @endif

</urlset>
