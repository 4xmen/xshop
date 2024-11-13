@extends('website.inc.website-layout')

@section('title')
    {{$post->title}} - {{config('app.name')}}
@endsection
@section('content')
    @if(findArea($area,$post)->use_default)
        @foreach(getParts('defaultHeader') as $part)
            @php($p = $part->getBladeWithData())
            @include($p['blade'],['data' => $p['data']])
        @endforeach
    @endif
    @foreach(getParts($area,$post) as $part)
        @php($p = $part->getBladeWithData($post))
        @include($p['blade'],['data' => $p['data']])
    @endforeach
    @if(findArea($area,$post)->use_default)
        @foreach(getParts('defaultFooter') as $part)
            @php($p = $part->getBladeWithData())
            @include($p['blade'],['data' => $p['data']])
        @endforeach
    @endif
@endsection
