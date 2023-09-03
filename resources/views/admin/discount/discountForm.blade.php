@extends('admin.adminlayout')
@section('page_title')
    @if(!isset($discount))
        {{__('New discount')}}
    @else
        {{__('Edit discount')}}: {{$discount->name}}
    @endif
    -
@endsection
@section('content')
    <div class="container">
        <h1>
            @if(!isset($discount))
                {{__('New Discount')}}
            @else
                {{__('Edit Discount')}}: {{$discount->code}}
            @endif
        </h1>
        @include('starter-kit::component.err')

        <form enctype="multipart/form-data"  method="post"
              @if(!isset($discount)) action="{{route('admin.discount.store')}}"
              @else  action="{{route('admin.discount.update',$discount->id)}}" @endif>

            @csrf

                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="type">
                                {{__('Type')}}
                            </label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror"   >
                                    <option value="price"  @if (old('type',$discount->type??null) == 'price' ) selected @endif > {{__("By price")}} </option>
                                    <option value="percent"  @if (old('type',$discount->type??null) == 'percent' ) selected @endif > {{__("By percent")}} </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="amount">
                                {{__('Amount')}}
                            </label>
                            <input name="amount" type="text" class="form-control @error('amount') is-invalid @enderror" placeholder="{{__('Amount')}}" value="{{old('amount',$discount->amount??null)}}"  />
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="code">
                                {{__('Code')}}
                            </label>
                            <input name="code" type="text" class="form-control @error('code') is-invalid @enderror" placeholder="{{__('Code')}}" value="{{old('code',$discount->code??null)}}"  />
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="expire">
                                {{__('Expire  date')}}
                            </label>
                            <input placeholder="{{__("Expire date")}}" type="text" data-reuslt="#exp-date"
                                   class="form-control @error('expire') is-invalid @enderror dtp" @if(isset($discount))  value="{{$discount->expire->jdate('Y/m/d')}}"  @endif>
                            <input type="hidden" name="expire" id="exp-date"  @if(isset($discount))  value="{{strtotime($discount->expire)}}" @endif>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="product_id">
                                {{__('Product')}}
                            </label>
                            <select name="product_id" id="product_id" class="form-control sel2  @error('product_id') is-invalid @enderror"   >
                                <option value=""> {{__("No product")}} </option>
                                @foreach($products as $product )
                                    <option value="{{ $product->id }}"  @if (old('product_id',$discount->product_id??null) == $product->id ) selected @endif > {{$product->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label> &nbsp; </label>
                        <input type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"   />
                    </div>
                </div>

        </form>
    </div>
@endsection
@section('content-with-js')
@endsection
