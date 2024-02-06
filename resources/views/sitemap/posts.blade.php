@extends('sitemap.layout')
@section('content')
    <url>
        <loc>{{route('posts')}}</loc>
        <lastmod>{{ $items[0]->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>1</priority>
    </url>
    @foreach($items as $item)
    <url>
        <loc>{{route('post.show',$item->slug)}}</loc>
        <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
    @if(config('app.xlang'))
        @foreach(\App\Models\Xlang::where('is_default', 0)->get() as $lang)
            <url>
                <loc>{{route('lang.post.show',[$lang->tag,$item->slug])}}</loc>
                <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.7</priority>
            </url>
        @endforeach
    @endif
@endsection
