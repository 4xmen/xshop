@extends('layouts.app')

@section('title')
    {{__("Design :AREA",['AREA' =>  $model . ' [' . $m->id.']'])}}
@endsection

@section('content')

    @include('components.err')
    <form action="{{route('admin.area.update.model',[$model,$m->id])}}" method="post">
        @csrf
        <div class="general-form mb-5">
            <h1>
                {{__("Design :AREA",['AREA' =>  $model . ' [' . $m->id.']'])}}
            </h1>


            <div class="form-group p-3">

                <div class="form-check form-switch">
                    <input value="1" class="form-check-input  @error('use_default') is-invalid @enderror" name="use_default" @if( $data['use_default']) checked @endif type="checkbox" id="use_default">
                    <label class="form-check-label" for="use_default"> {{__('Use default')}}</label>
                </div>
            </div>
            <area-designer
                image-link="{{route('admin.area.image',['',''])}}"
                :parts='@json($data['parts'])'
                :valids='@json($valids)'
                :area='@json($data)'
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
@endsection
