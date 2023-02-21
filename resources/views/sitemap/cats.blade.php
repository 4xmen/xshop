@extends('sitemap.layout')
@section('content')
    @foreach($items as $item)

    <url>
        <loc>{{route('cat',$item->slug)}}</loc>
        <lastmod>{{ $item->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
@endsection
