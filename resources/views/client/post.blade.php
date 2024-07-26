@extends('website.inc.website-layout')

@section('title')
    {{$post->title}} - {{config('app.name')}}
@endsection
@section('content')
    <main>
    @foreach(getParts($area) as $part)
        @php($p = $part->getBladeWithData($post))
        @include($p['blade'],['data' => $p['data']])
    @endforeach
    </main>
@endsection
