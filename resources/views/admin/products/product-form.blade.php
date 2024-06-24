@extends('layouts.app')

@section('title')
    @if(isset($item))
        {{__("Edit product")}} [{{$item->name}}]
    @else
        {{__("Add new product")}}
    @endif -
@endsection

@section('content')

    @if(hasRoute('create') && isset($item))
        <a class="action-btn circle-btn"
           data-bs-toggle="tooltip"
           data-bs-placement="top"
           data-bs-custom-class="custom-tooltip"
           data-bs-title="{{__("Add another one")}}"
           href="{{getRoute('create')}}"
        >
            <i class="ri-add-line"></i>
        </a>
    @else
        <a class="action-btn circle-btn"
           data-bs-toggle="tooltip"
           data-bs-placement="top"
           data-bs-custom-class="custom-tooltip"
           data-bs-title="{{__("Show list")}}"
           href="{{getRoute('index',[])}}"
        >
            <i class="ri-list-view"></i>
        </a>
    @endif

    <form
        @if(isset($item))
            id="product-form-edit"
        action="{{getRoute('update',$item->{$item->getRouteKeyName()})}}"
        @else
            id="product-form-create"
        action="{{getRoute('store')}}"
        @endif
        class="product-form pb-5 pb-5"
        method="post" enctype="multipart/form-data">
        @csrf
        @if(isset($item))
            <input type="hidden" name="id" value="{{$item->id}}"/>
        @endif
        <ul class="steps">
            <li data-tab="step1"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{__("Basic data")}}">
                <i class="ri-pages-line"></i>
            </li>
            <li data-tab="step2"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{__("Medias")}}">
                <i class="ri-image-2-line"></i>
            </li>
            <li data-tab="step3"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{__("Additional data")}}">
                <i class="ri-list-check-2"></i>
            </li>
            <li data-tab="step4"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                data-bs-custom-class="custom-tooltip"
                data-bs-title="{{__("Publish")}}">
                <i class="ri-save-3-line"></i>
            </li>
        </ul>
        @include('components.err')
        <div id="step-tabs">
            <div id="step1">
                <div class="card">
                    <div class="card-header">
                        {{__("Basic data")}}
                    </div>
                    <div class="card-body">
                        @include('admin.products.sub-pages.product-step1')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-light">
                            {{__("Publish")}}
                        </button>
                        <button type="button" class="btn btn-light step-next">
                            {{__("Next")}}
                        </button>
                    </div>
                </div>

            </div>
            <div id="step2">
                <div class="card">
                    <div class="card-header">
                        {{__("Medias")}}
                    </div>
                    <div class="card-body">
                        @include('admin.products.sub-pages.product-step2')
                    </div>
                    <div class="card-footer">
                        <!-- code -->
                        <button type="submit" class="btn btn-light">
                            {{__("Publish")}}
                        </button>
                        <button type="button" class="btn btn-light step-next">
                            {{__("Next")}}
                        </button>
                        <button type="button" class="btn btn-light step-prev">
                            {{__("Previous")}}
                        </button>
                    </div>
                </div>
            </div>
            <div id="step3">
                <div class="card">
                    <div class="card-header">
                        {{__("Additional data")}}
                    </div>
                    <div class="card-body">
                        @include('admin.products.sub-pages.product-step3')
                    </div>
                    <div class="card-footer">
                        <!-- code -->
                        <button type="submit" class="btn btn-light">
                            {{__("Publish")}}
                        </button>
                        <button type="button" class="btn btn-light step-next">
                            {{__("Next")}}
                        </button>
                        <button type="button" class="btn btn-light step-prev">
                            {{__("Previous")}}
                        </button>
                    </div>
                </div>
            </div>
            <div id="step4">
                <div class="card">
                    <div class="card-header">
                        {{__("Publish")}}
                    </div>
                    <div class="card-body">
                        @include('admin.products.sub-pages.product-step4')
                    </div>
                    <div class="card-footer">
                        <!-- code -->
                        <button type="submit" class="btn btn-light">
                            {{__("Publish")}}
                        </button>
                        <button type="button" class="btn btn-light step-prev">
                            {{__("Previous")}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <br>
    <br>
    @yield('out-of-form')
@endsection
@section('js-content')
    <script>
        var currentEditLink = '{{route('admin.product.edit','')}}/';
        var currentUpdateLink = '{{route('admin.product.update','')}}/';
    </script>
@endsection
