@extends('website.inc.website-layout')

@section('title')
    {{$title}} - {{config('app.name')}}
@endsection
@php
if ($group->bg != null){
    $bg = $group->bgUrl();
}
@endphp
@section('content')
    <main>
    @foreach(getParts($area) as $part)
        @php($p = $part->getBladeWithData())
        @include($p['blade'],['data' => $p['data']])
    @endforeach
    </main>
@endsection
