@extends('layouts.app')

@section('title')
    {{__("Area design")}}
@endsection
@section('content')
    @if(config('app.demo'))
        <div class="alert alert-warning">
            {{__("Theme loaded every :M minutes in demo version", ['M' => 5])}}
            {{__("or build it using the button below")}}
        </div>
    @endif
    @include('components.err')
    <div class="row">
        @foreach($areas as $area)
            <div class="col-md-4">
                <a class="area-list-item" href="{{route('admin.area.design',$area->name)}}">
                    <i class="{{$area->icon}}"></i>
                    {{__(readable($area->name))}}
                </a>
            </div>
        @endforeach
            <div class="col-md-4">
                <a class="area-list-item " style="background: blueviolet" href="{{route('admin.area.build')}}">
                    <i class="ri-hammer-line"></i>
                    {{__("Build assets")}}
                </a>
            </div>
    </div>
@endsection
