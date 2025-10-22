@extends('admin.templates.panel-list-template')

@section('list-title')
    <i class="ri-user-3-line"></i>
    {{__("Customers list")}}
@endsection
@section('title')
    {{__("Customers list")}} -
@endsection
@section('filter')
    {{--  Other filters --}}
    <div class=" mt-2">
        <div class="form-group">
            <label for="start_date">
                {{__("Start date")}}
            </label>
            <vue-datetime-picker-input
                xid="start_date"   xname="start_date" xtitle="{{__("Start date")}}" :timepicker="true"
                @if(app()->getLocale() != 'fa')  def-tab="1" xshow="datetime"  @else xshow="pdatetime"  @endif
            @if(request()->filled('start_date')) :xvalue="{{request()->input('start_date','')}}" @endif
            ></vue-datetime-picker-input>
        </div>
    </div>
    <div class="mt-2 mb-2">
        <div class="form-group">
            <label for="end_date">
                {{__("End date")}}
            </label>
            <vue-datetime-picker-input
                xid="end_date" xname="end_date" xtitle="{{__("End date")}}"
                :timepicker="true" @if(app()->getLocale() != 'fa')  def-tab="1"
                xshow="datetime"  @else xshow="pdatetime"  @endif
                @if(request()->filled('end_date')) :xvalue="{{request()->input('end_date','')}}" @endif

            ></vue-datetime-picker-input>
        </div>
    </div>
@endsection
@section('bulk')
    {{--    <option value="-"> - </option> --}}
@endsection
