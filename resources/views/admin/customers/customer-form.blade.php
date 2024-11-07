@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit customer")}} [{{$item->name}}]
    @else
        {{__("Add new customer")}}
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
            @if(isset($item))
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-user-3-line"></i>
                        {{__("Avatar")}}
                    </h3>
                    <img src="{{$item->avatar()}}" class="img-fluid mb-3" alt="" data-open-file="#avatar-input">
                    <input type="file" name="avatar" id="avatar-input"  accept="image/jpeg">
                </div>
                <div class="item-list mb-3">
                    <h3 class="p-3">
                        <i class="ri-user-location-line"></i>
                        {{__("Addresses")}}
                    </h3>
                    <address-input
                        list-link="{{route('admin.address.customer',$item->id)}}"
                        add-link="{{route('admin.address.store',$item->id)}}"
                        update-link="{{route('admin.address.update','')}}"
                        rem-link="{{route('admin.address.destroy','')}}"
                        state-link="{{route('v1.state.index')}}"
                        cities-link="{{route('v1.state.show','')}}"
                        :dark-mode="true"
                        :translate='{{vueTranslate([
            'addr-editor' => __('Address editor'),
            'state' => __('State'),
            'city' => __('City'),
            'address' => __('Address'),
            'post-code' => __('Post code'),
            ])}}'
                    ></address-input>
                </div>
            @endif

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">
                <h1>
                    @if(isset($item))
                        {{__("Edit customer")}} [{{$item->name}}]
                    @else
                        {{__("Add new customer")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="name">
                                {{__('Name')}}
                            </label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="{{__('Name')}}" value="{{old('name',$item->name??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="email">
                                {{__('Email')}}
                            </label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   placeholder="{{__('Email')}}" value="{{old('email',$item->email??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="credit">
                                {{__('Credit')}}
                            </label>
                            <currency-input :xvalue="{{old('credit',$item->credit??0)}}"
                                            xname="credit" xid="credit"
                                            @error('credit') :err="true" @enderror>
                            </currency-input>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <div class="form-group">
                            <label for="dp">
                                {{__('Date of born')}}
                            </label>
                            <vue-datetime-picker-input
                                :xmax="{{strtotime('yesterday')}}"
                                xid="dp" xname="dob"  xtitle="{{__("Date of born")}}"  @if(app()->getLocale() != 'fa')  def-tab="1" xshow="date"  @else xshow="pdate"  @endif
                                @if(isset($item)) :xvalue="{{strtotime($item->dob)}}" @endif
                                :timepicker="false"
                            ></vue-datetime-picker-input>
                        </div>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="height">
                            {{__('Height')}}
                        </label>
                        <input name="height" type="text" class="form-control @error('height') is-invalid @enderror"
                               placeholder="{{__('Height')}}" value="{{old('height',$item->height??null)}}"
                               minlength="2"/>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="weight">
                            {{__('Weight')}}
                        </label>
                        <input name="weight" type="text" class="form-control @error('weight') is-invalid @enderror"
                               placeholder="{{__('Weight')}}" value="{{old('weight',$item->weight??null)}}"
                               minlength="2"/>
                    </div>
                    <div class="col-md-3 mt-3">
                        <label for="sex">
                            {{__('Sex')}}
                        </label>
                        <select name="sex" id="sex" class="form-control">
                            <option value="MALE"> {{__("Male")}} </option>
                            <option value="FEMALE" @if(isset($item) && $item->sex == 'FEMALE') selected @endif> {{__("Female")}} </option>
                        </select>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-group">
                            <label for="mobile">
                                {{__('Mobile')}}
                            </label>
                            <input name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                                   placeholder="{{__('Mobile')}}" value="{{old('mobile',$item->mobile??null)}}"
                                   minlength="10"/>
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
                                   value="{{old('password_confirmation',$item->password_confirmation??null)}}"/>
                        </div>
                    </div>
                    <div class="col-md-2 mt-3">

                        <div class="form-check form-switch pt-4 mt-2">

                            <input class="form-check-input  @error('colleague') is-invalid @enderror"
                                   type="checkbox" id="colleague" name="colleague"
                                   @if (isset($item) && $item->colleague)
                                       checked
                                @endif>
                            <label class="form-check-label" for="colleague">{{__("Colleague")}}</label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="description">
                                {{__('Description')}}
                            </label>
                            <textarea name="description" id="description" type="password"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="{{__('Description')}}">{{old('description',$item->description??null)}}</textarea>
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
