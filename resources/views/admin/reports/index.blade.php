@extends('layouts.app')

@section('content')
    <div class="report-grid">
        <a href="{{route('admin.report.basket')}}" class="report-btn">
            <i class="ri-shopping-bag-4-fill"></i>
            {{__("Basket report")}}
        </a>
        <a href="{{route('admin.report.financial')}}" class="report-btn">
            <i class="ri-coin-line"></i>
            {{__("Financial report")}}
        </a>
        <a href="{{route('admin.report.inventory')}}" class="report-btn">
            <i class="ri-box-1-line"></i>
            {{__("Inventory report")}}
        </a>
        <a href="{{route('admin.report.period-sales')}}" class="report-btn">
            <i class="ri-line-chart-line"></i>
            {{__("Period sales report")}}
        </a>
        <a href="{{route('admin.report.customer-behavior')}}" class="report-btn">
            <i class="ri-user-star-line"></i>
            {{__("Customer behavior report")}}
        </a>
        <a href="{{route('admin.report.forecast')}}" class="report-btn">
            <i class="ri-bar-chart-grouped-line"></i>
            {{__("Forecast report")}}
        </a>
        <a href="{{route('admin.report.returns')}}" class="report-btn">
            <i class="ri-refund-line"></i>
            {{__("Returns report")}}
        </a>
        <a href="{{route('admin.report.top-products')}}" class="report-btn">
            <i class="ri-sort-asc"></i>
            {{__("Top products report")}}
        </a>
        <a href="#" class="report-btn">
            <i class="ri-eye-line"></i>
            {{__("Visits report")}}
        </a>
    </div>
@endsection
