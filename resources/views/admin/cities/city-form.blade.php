@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit city")}} [{{$item->name}}]
    @else
        {{__("Add new city")}}
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
                    <i class="ri-map-2-line"></i>
                    {{__("Change latitude and longitude")}}
                </h3>
                <div class="p3">
                    <lat-lng dark-mode="true"
                             @if(isset($item))
                             :ilat="{{$item->lat}}"
                             :ilng="{{$item->lng}}"
                            @endif
                             :izoom="12"
                    ></lat-lng>
                </div>
            </div>

        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit city")}} [{{$item->name}}]
                    @else
                        {{__("Add new city")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="name" >
                                {{__('Name')}}
                            </label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"  id="name" placeholder="{{__('Name')}}" value="{{old('name',$item->name??null)}}"  />
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="state_id" >
                                {{__('State')}}
                            </label>
                            <searchable-select
                                @error('state_id') :err="true" @enderror
                                :items='@json($states)'
                                title-field="name"
                                value-field="id"
                                xlang="{{config('app.locale')}}"
                                xid="state_id"
                                xname="state_id"
                                @error('state_id') :err="true" @enderror
                                xvalue='{{old('state_id',$item->state_id??null)}}'
                                :close-on-Select="true"></searchable-select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="lat" >
                                {{__('Latitude')}}
                            </label>
                            <input readonly name="lat" type="text" class="form-control @error('lat') is-invalid @enderror"  id="lat" placeholder="{{__('Latitude')}}" value="{{old('lat',$item->lat??null)}}"  />
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="lng" >
                                {{__('Longitude')}}
                            </label>
                            <input readonly name="lng" type="text" class="form-control @error('lng') is-invalid @enderror"  id="lng" placeholder="{{__('Longitude')}}" value="{{old('lng',$item->lng??null)}}"  />
                        </div>
                    </div>
                    <div class="col-12">
                        <label> &nbsp; </label>
                        <input name=""  id="" type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"   />
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
