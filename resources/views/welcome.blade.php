@extends('website.inc.website-layout')

@section('title')
    welcome
@endsection
@section('content')
    @foreach(getParts('index') as $part)
        @php($p = $part->getBladeWithData())
        @include($p['blade'],['data' => $p['data']])
    @endforeach
@endsection
