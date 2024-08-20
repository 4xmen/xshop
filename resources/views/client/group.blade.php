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
        @if(\App\Models\Area::where('name',$area)->first()->use_default)
            @foreach(getParts('default_header') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
        @foreach(getParts($area) as $part)
            @php($p = $part->getBladeWithData())
            @include($p['blade'],['data' => $p['data']])
        @endforeach
        @if(\App\Models\Area::where('name',$area)->first()->use_default)
            @foreach(getParts('default_footer') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
    </main>
@endsection
