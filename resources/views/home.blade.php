@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row equal-height">
            <div class="col-lg-6 p-0 pe-lg-2 mb-3">
                <div class="card skewed-container">
                    <i class="ri-user-follow-line skewed-icon"></i>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 text-center">
                                <img src="{{asset('panel/images/xshop-logo.svg')}}" class="avatar-x64" alt="">
                            </div>
                            <div class="col-9 pt-1">
                                {{__("Welcome bak")}}
                                <h4 class="mt-2">
                                    {{auth()->user()->name}}
                                </h4>
                            </div>
                            <div class="p-4">
                                <div class="row text-center">
                                    <div class="col-6 mt-3">
                                        <h5>
                                            {{__("Posts")}}
                                        </h5>
                                        {{number_format(auth()->user()->posts()->count())}}
                                    </div>
                                    <div class="col-6 mt-3">
                                        <h5>
                                            {{__("Products")}}
                                        </h5>
                                        {{number_format(auth()->user()->products()->count())}}
                                    </div>
                                    <div class="col-6 mt-3">
                                        <h5>
                                            {{__("Comments")}}
                                        </h5>
                                        {{number_format(auth()->user()->comments()->count())}}
                                    </div>
                                    <div class="col-6 mt-3">
                                        <h5>
                                            {{__("Tickets")}}
                                        </h5>
                                        {{number_format(auth()->user()->tickets()->count())}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 p-0 px-lg-2 mb-3">
                <div class="card order-card h-100">
                    <div class="card-header">
                        {{__("Need process orders")}}
                    </div>
                    <div class="card-body">
                        <a href="#">
                            <i class="ri-shopping-bag-4-line"></i>
                            <h2>
                                {{number_format(\App\Models\Ticket::where('status','PAID')->count())}}
                            </h2>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 p-0 ps-lg-2 mb-3">
                <div class="card ticket-card h-100">
                    <div class="card-header">
                        {{__("Pending tickets")}}
                    </div>
                    <div class="card-body">
                        <a href="{{route('admin.ticket.index')}}">
                            <i class="ri-customer-service-2-line"></i>
                            <h2>
                                {{number_format(\App\Models\Invoice::where('status','PENDING')->count())}}
                            </h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12 mb-3 p-0" id="visitor-container">
                <div class="card">
                    <div class="card-header">
                        {{__("last month visits")}}
                    </div>
                    <div class="card-body">
                        <canvas id="visitor-chart" height="300"></canvas>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@section('js-content')
    <script>


        window.addEventListener('load', function () {

            if (isPaintedChart) {
                return;
            }

            isPaintedChart = true;

            let ctx = document.getElementById('visitor-chart').getContext('2d');
            let visits = @json($visits);
            document.getElementById('visitor-chart').setAttribute('width', document.querySelector('#visitor-container').clientWidth - 45);
            let chart = new window.chartjs(ctx, {
                // The type of chart we want to create
                type: 'line', // also try bar or other graph types

                // The data for our dataset
                data: {
                    labels: @json($dates),
                    // Information about the dataset
                    datasets: [
                        {
                            label: "{{__('Visitors')}}",
                            backgroundColor: 'rgba(128,0,255,0.1)',
                            borderColor: 'rgba(140,0,255,0.6)',
                            data: visits.subItem('count', 1),
                            fill: true,
                        },
                        {
                            label: "{{__('Visits')}}",
                            backgroundColor: 'rgba(255,0,0,0.1)',
                            borderColor: '#ff000099',
                            data: visits.subItem('visits', 1),
                            fill: true,
                        },
                    ]
                },

                // Configuration options
                options: {
                    layout: {
                        padding: 10,
                    },
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Precipitation in Toronto'
                    }
                }
            });
        });

    </script>
@endsection
