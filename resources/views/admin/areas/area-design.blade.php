@extends('layouts.app')

@section('title')
    {{__("Design :AREA",['AREA' => $area->name])}}
@endsection

@section('content')

    @include('components.err')
    <form action="{{route('admin.area.update',$area->name)}}" method="post">
        @csrf
        <div class="general-form mb-5">
            <h1>
                {{__("Design :AREA",['AREA' => $area->name])}} <i class="{{$area->icon}}"></i>
            </h1>

            @if(strpos($area->name,'default') !== 0  )

            <div class="form-group p-3">

                <div class="form-check form-switch">
                    <input value="1" class="form-check-input  @error('use_default') is-invalid @enderror" name="use_default" @if( isset($area) && $area->use_default) checked @endif type="checkbox" id="use_default">
                    <label class="form-check-label" for="use_default"> {{__('Use default')}}</label>
                </div>
            </div>
            @endif
            <area-designer
                image-link="{{route('admin.area.image',['',''])}}"
                :parts='@json($area->parts()->orderBy('sort')->get())'
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
            class="action-btn circle-btn"
            data-bs-toggle="tooltip"
            data-bs-placement="top"
            data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Save")}}"
        >
            <i class="ri-save-2-line"></i>
        </button>
    </form>
    @if($area->max > 0 && $area->parts()->count() > 1)

    <a
       href="{{route('admin.area.sort',$area->name)}}"
        class="action-btn circle-btn"
        data-bs-toggle="tooltip"
        data-bs-placement="top"
        data-bs-custom-class="custom-tooltip"
        data-bs-title="{{__("Sort")}}"
       style="inset-inline-end: 1.2rem;inset-inline-start: auto;"
    >
        <i class="ri-sort-asc"></i>
    </a>
    @endif
@endsection
