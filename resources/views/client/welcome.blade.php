@extends('website.inc.website-layout')

@section('title')
    {{config('app.name')}} - {{getSetting('subtitle')}}
@endsection
@section('content')
    <main>
        @if(\App\Models\Area::where('name',$area)->first()->use_default)
            @foreach(getParts('defaultHeader') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
        @foreach(getParts($area) as $part)
            @php($p = $part->getBladeWithData())
            @include($p['blade'],['data' => $p['data']])
        @endforeach
        @if(\App\Models\Area::where('name',$area)->first()->use_default)
            @foreach(getParts('defaultFooter') as $part)
                @php($p = $part->getBladeWithData())
                @include($p['blade'],['data' => $p['data']])
            @endforeach
        @endif
    </main>
@endsection
