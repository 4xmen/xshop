@extends('website.inc.website-layout')
@section('title')
    {{$title}}
@endsection
@section('content')
    @foreach(getParts('under-construction') as $part)
        @php($p = $part->getBladeWithData($model??null))
        @include($p['blade'],['data' => $p['data']])
    @endforeach
@endsection
