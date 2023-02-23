@extends('sitemap.layout')
@section('content')
    <url>
        <loc>{{route('products')}}</loc>
        <lastmod>{{ $items[0]->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>dayly</changefreq>
        <priority>1</priority>
    </url>
    @foreach($items as $item)

    <url>
        <loc>{{route('product',$item->slug)}}</loc>
        <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
@endsection
