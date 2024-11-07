@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit discount")}} [{{$item->title}}]
    @else
        {{__("Add new discount")}}
    @endif -
@endsection
@section('form')

    <div class="row">
        <div class="col-lg-3">

            @include('components.err')
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-message-3-line"></i>
                    {{__("Tips")}}
                </h3>
                <ul>
                    <li>
                        {{__("Recommends")}}
                    </li>
                </ul>
            </div>
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-message-3-line"></i>
                    {{__("Discount data")}}
                </h3>
                <div class="px-3 pb-4">
                    <div class=" mt-3">
                        <div class="form-group">
                            <label for="code">
                                {{__('Code')}}
                            </label>
                            <input name="code" type="text" class="form-control @error('code') is-invalid @enderror" placeholder="{{__('Code')}}" value="{{old('code',$item->code??null)}}"  />
                        </div>
                    </div>
                    <div class=" mt-3">
                        <div class="form-group">
                            <label for="expire">
                                {{__('Expire  date')}}
                            </label>
                            <vue-datetime-picker-input
                                :xmin="{{strtotime('yesterday')}}"
                                xid="dp" xname="expire" xtitle="Expire date"  @if(app()->getLocale() != 'fa')  def-tab="1" xshow="datetime"  @else xshow="pdatetime"  @endif
                                @if(isset($item)) :xvalue="{{strtotime($item->expire)}}" @endif
                                :timepicker="true"
                            ></vue-datetime-picker-input>
                        </div>
                    </div>
                    <div class=" mt-3">
                        <div class="form-group">
                            <label for="product_id">
                                {{__('Product')}}
                            </label>
                            <searchable-select
                                @error('product_id') :err="true" @enderror
                            :items='@json(\App\Models\Product::all(['id','name']))'
                                title-field="name"
                                value-field="id"
                                xlang="{{config('app.locale')}}"
                                xid="product_id"
                                xname="product_id"
                                @error('product_id') :err="true" @enderror
                                xvalue='{{old('product_id',$item->product_id??request()->get('product_id'))}}'
                                :close-on-Select="true"></searchable-select>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit discount")}} [{{$item->title}}]
                    @else
                        {{__("Add new discount")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="title">
                                {{__('Title')}}
                            </label>
                            <input name="title" type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="{{__('Title')}}" value="{{old('title',$item->title??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="body">
                                {{__('Description')}}
                            </label>
                            <textarea name="body" class="ckeditorx form-control @error('body') is-invalid @enderror"
                                      placeholder="{{__('Description')}}"
                                      rows="8">{{old('body',$item->body??null)}}</textarea>
                            {{--                                    @trix(\App\Post::class, 'body')--}}


                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="type">
                                {{__('Type')}}
                            </label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror"   >
                                @foreach(\App\Models\Discount::$doscount_type as $k => $v)
                                    <option
                                        value="{{ $v }}" {{ old("type", $item->type??null) == $v ? "selected" : "" }}>{{ __($v) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="amount">
                                {{__('Amount')}}
                            </label>

                            <currency-input xname="amount" xid="amount" @error('amount') xtitle="{{__('Title')}}"
                            :err="true" @enderror :xvalue="{{old('amount',$item->amount??null)}}"></currency-input>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label> &nbsp;</label>
                        <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
