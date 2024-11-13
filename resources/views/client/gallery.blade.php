@extends('website.inc.website-layout')

@section('title')
    {{$gallery->title}} - {{config('app.name')}}
@endsection
@section('content')
    <main>
        @if(findArea($area)->use_default)
            @foreach(getParts('defaultHeader') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
        @foreach(getParts($area) as $part)
            @php($p = $part->getBladeWithData($gallery))
            @include($p['blade'],['data' => $p['data']])
        @endforeach
        @if(findArea($area)->use_default)
            @foreach(getParts('defaultFooter') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
    </main>
@endsection
