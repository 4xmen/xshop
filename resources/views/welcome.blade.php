@extends('website.inc.website-layout')

@section('title')
    welcome
@endsection
@section('content')
    @foreach(getParts('index') as $part)
        @include($part->getBlade())
    @endforeach
@endsection
