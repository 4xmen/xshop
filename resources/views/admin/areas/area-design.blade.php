@extends('layouts.app')

@section('title')
    {{__("Design :AREA",['AREA' => $area->name])}}
@endsection

@section('content')

    <form action="{{route('admin.area.update',$area->name)}}" method="post">
        @csrf
        <div class="general-form mb-5">
            <h1>
                {{__("Design :AREA",['AREA' => $area->name])}} <i class="{{$area->icon}}"></i>
            </h1>

            <area-designer
                image-link="{{route('admin.area.image',['',''])}}"
                :parts='@json($area->parts)'
                :valids='@json($valids)'
                :area='@json($area)'
            ></area-designer>
            {{--        <div class="row">--}}
            {{--            @foreach($valids as $valid)--}}
            {{--                <div class="col-md-3">--}}
            {{--                    <img class="img-fluid" src="{{route('admin.area.image',[$valid['segment'],$valid['part']])}}" alt="{{$valid['segment'].'.'.$valid['part']}}">--}}
            {{--                    <h5 class="mt-2 text-center">--}}
            {{--                        {{$valid['data']['name']}} [v{{$valid['data']['version']}}]--}}
            {{--                    </h5>--}}
            {{--                </div>--}}
            {{--            @endforeach--}}
            {{--        </div>--}}
        </div>
        <button
            data-link="{{getRoute('sort-save')}}"
            id="save-sort"
            class="action-btn circle-btn"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Save")}}"
        >
            <i class="ri-save-2-line"></i>
        </button>
    </form>
@endsection
