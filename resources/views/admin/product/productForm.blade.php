@extends('admin.adminlayout')
@section('page_title')
    @if(!isset($product))
        {{__('New product')}}
    @else
        {{__('Edit product')}}: {{$product->title}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if(!isset($product))
                {{__('New Product')}}
            @else
                {{__('Edit Product')}}: {{$product->title}}
            @endif
        </h1>
        @include('starter-kit::component.err')

        <form enctype="multipart/form-data" class="row" method="post"
              id="saveProduct"
              @if(!isset($product)) action="{{route('admin.product.store')}}"
              @else  action="{{route('admin.product.update',$product->slug)}}" @endif>

            @csrf

            <section class="col-md-12">
                <div class="wizard">
                    <div class="steps">
                        <div class="hr">
                            <div class="prog"></div>
                        </div>
                        <div class="step">
                            <div class="circle">
                                <i class="fa fa-align-center"></i>
                            </div>
                            <h4>
                                {{__("Basic information")}}
                            </h4>
                        </div>
                        <div class="step">
                            <div class="circle">
                                <i class="fa fa-images"></i>
                            </div>
                            <h4>
                                {{__("Pictures")}}
                            </h4>
                        </div>
                        <div class="step">
                            <div class="circle">
                                <i class="fa fa-file-alt"></i>
                            </div>
                            <h4>
                                {{__("Advanced information")}}
                            </h4>
                        </div>
                        <div class="step">
                            <div class="circle">
                                <i class="fa fa-paper-plane"></i>
                            </div>
                            <h4>
                                {{__("Metas and publish")}}
                            </h4>
                        </div>
                    </div>
                    <div class="wizard-forms">
                        @include('admin.product.form.basicProductForm')
                        @include('admin.product.form.picProductForm')
                        @include('admin.product.form.advncProductForm')
                        @include('admin.product.form.publishProductForm')
                    </div>
                </div>
            </section>

        </form>
    </div>
@endsection
@section('content-with-js')
@endsection
