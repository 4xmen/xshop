@extends('admin.adminlayout')
@section('page_title')
    @if(!isset($customer))
        {{__('New customer')}}
    @else
        {{__('Edit customer')}}: {{$customer->name}}
    @endif
    -
@endsection
@section('content')
    <div class="container">

        <h1>
            @if(!isset($customer))
                {{__('New customer')}}
            @else
                {{__('Edit customer')}}: {{$customer->name}}
                {{--                {{$ccat->imgUrl()}}--}}
            @endif
        </h1>
        @include('starter-kit::component.err')
        <form id="customer" method="post" @if(!isset($customer)) action="{{route('admin.customer.store')}}"
              @else  action="{{route('admin.customer.update',$customer->id)}}" @endif enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="name">
                            {{__('Name')}}
                        </label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                               placeholder="{{__('Name')}}" value="{{old('name',$customer->name??null)}}"/>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="email">
                            {{__('Email')}}
                        </label>
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               placeholder="{{__('Email')}}" value="{{old('email',$customer->email??null)}}"/>
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="credit">
                            {{__('Credit')}}
                        </label>
                        <input name="credit" type="text" class="form-control currency @error('credit') is-invalid @enderror"
                               placeholder="{{__('Credit')}}" value="{{old('credit',$customer->credit??null)}}"/>
                    </div>
                </div>
                <div class="col-md-5 mt-3">
                    <div class="form-group">
                        <label for="postal_code">
                            {{__('postal_code')}}
                        </label>
                        <input name="postal_code" type="postal_code"
                               class="form-control @error('postal_code') is-invalid @enderror"
                               placeholder="{{__('postal_code')}}"
                               value="{{old('postal_code',$customer->postal_code??null)}}"/>
                    </div>
                </div>
                <div class="col-md-5 mt-3">
                    <div class="form-group">
                        <label for="mobile">
                            {{__('Mobile')}}
                        </label>
                        <input name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                               placeholder="{{__('Mobile')}}" value="{{old('mobile',$customer->mobile??null)}}"
                               min-length="10"/>
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                    <div class="form-group pt-3">
                        <br>
                        <input name="colleague" type="checkbox"
                               @if (isset($customer) && $customer->colleague)
                               checked
                               @endif
                               class="form-check-inline @error('colleague') is-invalid @enderror"
                               placeholder="{{__('Colleague')}}"
                        />
                        <label for="colleague" class="form-check-label">
                            {{__('Colleague')}}
                        </label>
                    </div>
                </div>
                <div class="col-md-3 mt-3">
                    <div class="form-group">
                        <label for="password">
                            {{__('Password')}}
                        </label>
                        <input name="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="{{__('Password')}}" value="{{old('password',''??null)}}"/>
                    </div>
                </div>
                <div class="col-md-3 mt-3">
                    <div class="form-group">
                        <label for="password_confirmation">
                            {{__('password repeat')}}
                        </label>
                        <input name="password_confirmation" type="password"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               placeholder="{{__('password repeat')}}"
                               value="{{old('password_confirmation',$customer->password_confirmation??null)}}"/>
                    </div>
                </div>
                <div class="col-md-3 mt-3">
                    <div class="form-group">
                        <label for="state"
                               class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>
                        <select id="state" data-val="{{old('state',$customer->state??null)}}" type="text"
                                class="form-control @error('state') is-invalid @enderror" name="state" required>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-3">
                    <div class="form-group">
                        <label for="city"
                               class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                        <select id="city" data-val="{{old('city',$customer->city??null)}}" type="text"
                                class="form-control @error('city') is-invalid @enderror" name="city" required>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="address">
                            {{__('Address')}}
                        </label>
                        <textarea name="address" id="address" type="password"
                                  class="form-control @error('address') is-invalid @enderror"
                                  placeholder="{{__('Address')}}">{{old('address',$customer->address??null)}}</textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="description">
                            {{__('Description')}}
                        </label>
                        <textarea name="description" id="description" type="password"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="{{__('Description')}}">{{old('description',$customer->description??null)}}</textarea>
                    </div>
                </div>
                <div class="col-md-12">
                    <label> &nbsp;</label>
                    <input name="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                </div>
            </div>
        </form>
    </div>
@endsection
