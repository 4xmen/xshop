
@extends('layouts.app')

@section('title')
    {{__("Area design")}}
@endsection
@section('content')
    <div class="row">
        @foreach($areas as $area)
            <div class="col-md-4">
                <a class="area-list-item" href="{{route('admin.area.design',$area->name)}}">
                    <i class="{{$area->icon}}"></i>
                    {{__(readable($area->name))}}
                </a>
            </div>
        @endforeach
    </div>
@endsection
