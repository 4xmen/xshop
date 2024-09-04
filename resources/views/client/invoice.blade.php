@extends('website.inc.website-layout')

@section('title')
    {{$title}} - {{config('app.name')}}
@endsection
@section('content')
    <main>
        <div class="no-print">
            @if(\App\Models\Area::where('name',$area)->first()->use_default)
                @foreach(getParts('default_header') as $part)
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
            @if(\App\Models\Area::where('name',$area)->first()->use_default)
                @foreach(getParts('default_footer') as $part)
                    @php($p = $part->getBladeWithData())
                    @include($p['blade'],['data' => $p['data']])
                @endforeach
            @endif
        </div>
    </main>
@endsection
