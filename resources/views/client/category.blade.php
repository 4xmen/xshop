@extends('website.inc.website-layout')

@section('title')
    {{$title}} - {{config('app.name')}}
@endsection
@php
if ($category->bg != null){
    $bg = $category->bgUrl();
}
@endphp
@section('content')
    <main>
        <input type="hidden" id="page-image" value="{{$category->imgUrl()}}">
        @if(findArea($area,$category)->use_default)
            @foreach(getParts('defaultHeader') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
        @foreach(getParts($area,'$category'.$category->id) as $part)
            @php($p = $part->getBladeWithData($category))
            @include($p['blade'],['data' => $p['data']])
        @endforeach
        @if(findArea($area,$category)->use_default)
            @foreach(getParts('defaultFooter') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
    </main>
@endsection
