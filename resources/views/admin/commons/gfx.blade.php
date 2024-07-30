@extends('layouts.app')
@section('title')
    {{__("GFX")}} -
@endsection
@section('content')
    <form action="{{route('admin.gfx.update')}}" method="post" class="mb-5 pb-5">
        @csrf
        @include('components.err')
        <gfxer
            :items='@json(\App\Models\Gfx::all('key','label','value'))'
            :previews='@json($previews)'
        ></gfxer>
        <button
            data-link="{{getRoute('update')}}"
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
