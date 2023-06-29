@extends('admin.adminlayout')
@section('page_title')
    @if(!isset($invoice))
        {{__('New invoice')}}
    @else
        {{__('Edit invoice')}}: {{$invoice->customer->name}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if(!isset($invoice))
                {{__('New invoice')}}
            @else
                {{__('Edit invoice')}}: {{$invoice->customer->name}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        <form id="invoice" method="post" @if(!isset($invoice)) action="{{route('admin.invoice.store')}}"
              @else  action="{{route('admin.invoice.update',$invoice->hash)}}" @endif enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="customer_id">
                            {{__('Customer')}}
                        </label>
                        <select name="customer_id" data-live-search="true" id="customer_id"
                                class="form-control searchable  @error('customer_id') is-invalid @enderror">
                            @foreach(\App\Models\Customer::all() as $customer )
                                <option value="{{ $customer->id }}"
                                        @if (old('customer_id',$invoice?->customer_id??null) == $customer->id ) selected @endif > {{$customer->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="status">
                            {{__('Status')}}
                        </label>
                        <select name="status" data-live-search="true" id="status"
                                class="form-control searchable  @error('status') is-invalid @enderror">
                            <option value="{{\App\models\Invoice::COMPLETED}}"
                                    @if (old('status',$invoice->status??null) ==\App\models\Invoice::COMPLETED  ) selected @endif >
                                {{__(\App\models\Invoice::COMPLETED)}} </option>
                            <option value="{{\App\models\Invoice::PROCESSING}}"
                                    @if (old('status',$invoice->status??null) ==\App\models\Invoice::PROCESSING  ) selected @endif >
                                {{__(\App\models\Invoice::PROCESSING)}} </option>

                            <option value="{{\App\models\Invoice::PENDING}}"
                                    @if (old('status',$invoice->status??null) ==\App\models\Invoice::PENDING  ) selected @endif >
                                {{__(\App\models\Invoice::PENDING)}} </option>

                            <option value="{{\App\models\Invoice::FAILED}}"
                                    @if (old('status',$invoice->status??null) ==\App\models\Invoice::FAILED  ) selected @endif >
                                {{__(\App\models\Invoice::FAILED)}} </option>

                            <option value="{{\App\models\Invoice::CANCELED}}"
                                    @if (old('status',$invoice->status??null) ==\App\models\Invoice::CANCELED  ) selected @endif >
                                {{__(\App\models\Invoice::CANCELED)}} </option>

                        </select>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="tracking_code">
                            {{__('Tracking code')}}
                        </label>
                        <input name="tracking_code" type="text"
                               class="form-control @error('tracking_code') is-invalid @enderror"
                               placeholder="{{__('Tracking code')}}"
                               value="{{old('tracking_code',$invoice->tracking_code??null)}}"/>
                    </div>
                </div>
                @if(isset($invoice))
                    @foreach($invoice->products as $product )

                        <div class="col-md-6">
                            <div class="card">
                                <div id="product_{{$product->id}}" class="row">
                                    <div class="col-md-6 mt-3">
                                        <div class="form-group">
                                            <label for="products">
                                                {{__('Product')}}
                                            </label>
                                            <select data-live-search="true" name="products.ids[]"
                                                    data-live-search="true" id="products"
                                                    class="form-control searchable">
                                                @foreach(\App\models\Product::all() as $allProduct )
                                                    <option value="{{ $allProduct->id }}"
                                                            @if ($product->id==$allProduct->id  ) selected @endif > {{$allProduct->name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <div class="form-group">
                                            <label for="count">
                                                {{__('Count')}}
                                            </label>
                                            <input type="number" name="products.counts[]"
                                                   value="{{$product->pivot->count}}"
                                                   id="" class="form-control">
                                            <button class="btn btn-outline-danger "
                                                    onclick="document.getElementById('product_{{$product->id}}').remove()">
                                                X
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    @endforeach
                @endif

                <div class="col-md-12">
                    <label> &nbsp;</label>
                    <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                </div>
            </div>
        </form>
    </div>
@endsection
