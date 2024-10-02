@extends('website.inc.website-layout')

@section('title')
    {{$title}} - {{config('app.name')}}
@endsection
@section('content')
    <main>
        <div class="no-print">
            @if(findArea($area)->use_default)
                @foreach(getParts('defaultHeader') as $part)
                    @php($p = $part->getBladeWithData())
                    @include($p['blade'],['data' => $p['data']])
                @endforeach
            @endif
        </div>
        @foreach(getParts($area) as $part)
            @php($p = $part->getBladeWithData())
            @include($p['blade'],['data' => $p['data']])
        @endforeach
        <div class="no-print">
            @if(findArea($area)->use_default)
                @foreach(getParts('defaultFooter') as $part)
                    @php($p = $part->getBladeWithData())
                    @include($p['blade'],['data' => $p['data']])
                @endforeach
            @endif
        </div>
    </main>
@endsection
