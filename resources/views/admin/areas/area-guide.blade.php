@extends('layouts.app')

@section('title')
    {{__("Design guide")}}
@endsection

@section('content')

    @include('components.err')
    <div class="container-fluid">
        <ul class="list-group">
            @foreach($areas as $area)
                <li class="list-group-item">
                    <h4 class="float-start mx-4">
                        {{$area->name}}
                    </h4>
                    @foreach(json_decode($area->valid_segments) as $segment)
                        <span class="badge bg-primary mx-1 fs-6">
                            {{$segment}}
                        </span>
                    @endforeach
                </li>
            @endforeach
        </ul>
    </div>
@endsection
