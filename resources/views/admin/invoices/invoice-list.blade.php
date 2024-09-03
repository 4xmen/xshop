@extends('admin.templates.panel-list-template')

@section('list-title')
    <i class="ri-user-3-line"></i>
    {{__("Invoices list")}}
@endsection
@section('title')
    {{__("Invoices list")}} -
@endsection
@section('filter')
    <h2>
        <i class="ri-shield-check-line"></i>
        {{__("Status")}}:
    </h2>
    <searchable-multi-select
        :items='{{arrayNormolizeVueCompatible(\App\Models\Invoice::$invoiceStatus, true)}}'
        title-field="name"
        value-field="name"
        xname="filter[status]"
        :xvalue='{{request()->input('filter.status','[]')}}'
        :close-on-Select="true"></searchable-multi-select>
@endsection
@section('bulk')
    {{--    <option value="-"> - </option> --}}
@endsection
