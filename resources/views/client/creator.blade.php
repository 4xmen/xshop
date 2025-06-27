@extends('website.inc.website-layout')

@section('title')
    {{$title}} - {{config('app.name')}}
@endsection

@section('content')
    <main>
        <input type="hidden" id="page-image" value="{{$creator->imgUrl()}}">
        @if(findArea($area,$creator)->use_default)
            @foreach(getParts('defaultHeader') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
        @foreach(getParts($area,'creator'.$creator->id) as $part)
            @php($p = $part->getBladeWithData($creator))
            @include($p['blade'],['data' => $p['data']])
        @endforeach
        @if(findArea($area,$creator)->use_default)
            @foreach(getParts('defaultFooter') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
    </main>
@endsection
