@extends('admin.templates.panel-form-template')
@section('title')
    @if(isset($item))
        {{__("Edit redirect")}} [{{$item->id}}]
    @else
        {{__("Add new redirect")}}
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
                        {{__("You can define an expire time to expire redirect")}}
                    </li>
                    <li>
                        {{__("The changes in redirects occur every 5 minutes.")}}
                    </li>
                </ul>
            </div>
            <div class="item-list mb-3">
                <h3 class="p-3">
                    <i class="ri-calendar-2-line"></i>
                    {{__("Additional data")}}
                </h3>
                <div class=" p-3">
                    <div class="form-group">
                        <label for="expire">
                            {{__('Expire  date')}}
                        </label>
                        <vue-datetime-picker-input
                            :xmin="{{strtotime('yesterday')}}"
                            xid="dp" xname="expire" xtitle="Expire date" @if(app()->getLocale() != 'fa')  def-tab="1"
                            xshow="date" @else xshow="pdate" @endif
                            @if(isset($item)) :xvalue="{{strtotime($item->expire)}}" @endif
                            :timepicker="false"
                        ></vue-datetime-picker-input>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-9 ps-xl-1 ps-xxl-1">
            <div class="general-form ">

                <h1>
                    @if(isset($item))
                        {{__("Edit redirect")}} [{{$item->id}}]
                    @else
                        {{__("Add new redirect")}}
                    @endif
                </h1>

                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="src">
                                {{__('Source')}}
                            </label>
                            <input name="source" type="text"
                                   class="form-control @error('source') is-invalid @enderror"
                                   placeholder="{{__('Source')}}"
                                   value="{{old('source',$item->source??null)}}" id="src"/>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="destination">
                                {{__('Destination')}}
                            </label>
                            <input name="destination" type="text"
                                   class="form-control @error('destination') is-invalid @enderror"
                                   placeholder="{{__('Destination')}}"
                                   value="{{old('destination',$item->destination??null)}}" id="destination"/>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="status">
                                {{__('Status')}}
                            </label>
                            <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                <option value="1"
                                        @if (old('status',$item->status??null) == '1' ) selected @endif >{{__("Active")}} </option>
                                <option value="0"
                                        @if (old('status',$item->status??null) == '0' ) selected @endif >{{__("Passive")}} </option>
                            </select>
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
