@extends('website.inc.website-layout')

@section('title')
    {{$title}} - {{config('app.name')}}
@endsection
@section('content')
    <main>
        <input type="hidden" id="page-image" value="{{$product->imgUrl()}}">
        @if(findArea($area,$product)->use_default)
            @foreach(getParts('defaultHeader') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
            @foreach(getParts($area,'$product'.$product->id) as $part)
                @php($p = $part->getBladeWithData($product))
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @if(findArea($area,$product)->use_default)
            @foreach(getParts('defaultFooter') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
    </main>
@endsection
