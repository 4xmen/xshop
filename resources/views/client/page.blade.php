@extends('website.inc.website-layout')

@section('title')
    {{$page->title}} - {{config('app.name')}}
@endsection
@section('content')
    <main>
        <input type="hidden" id="page-image" value="{{$page->imgUrl()}}">
        @if(findArea($area,$page)->use_default)
            @foreach(getParts('defaultHeader') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
        @foreach(getParts($area,'page'.$page->id) as $part)
            @php($p = $part->getBladeWithData($page))
            @include($p['blade'],['data' => $p['data']])
        @endforeach
        @if(findArea($area,$page)->use_default)
            @foreach(getParts('defaultFooter') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
    </main>
@endsection
