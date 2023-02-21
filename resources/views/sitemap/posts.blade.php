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
        <loc>{{route('n.show',$item->slug)}}</loc>
        <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach
@endsection
