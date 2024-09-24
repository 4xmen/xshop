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
                                <img src="{{auth()->user()->avatar()}}" class="avatar-x64" alt="">
                            </div>
                            <div class="col-9 pt-1">
                                {{__("Welcome back")}}
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
                                        <div class="progress" role="progressbar" style="height: 3px">
                                            <div class="progress-bar"
                                                 style="width: {{auth()->user()->postsPercent()}}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <h5>
                                            {{__("Products")}}
                                        </h5>
                                        {{number_format(auth()->user()->products()->count())}}
                                        <div class="progress" role="progressbar" style="height: 3px">
                                            <div class="progress-bar bg-warning"
                                                 style="width: {{auth()->user()->productsPercent()}}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <h5>
                                            {{__("Comments")}}
                                        </h5>
                                        {{number_format(auth()->user()->comments()->count())}}
                                        <div class="progress" role="progressbar" style="height: 3px">
                                            <div class="progress-bar bg-danger"
                                                 style="width: {{auth()->user()->commentsPercent()}}%"></div>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <h5>
                                            {{__("Tickets")}}
                                        </h5>
                                        {{number_format(auth()->user()->tickets()->count())}}
                                        <div class="progress" role="progressbar" style="height: 3px">
                                            <div class="progress-bar bg-success"
                                                 style="width: {{auth()->user()->ticketsPercent()}}%"></div>
                                        </div>
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
                        <a href='{{route('admin.invoice.index')}}?filter%5Bstatus%5D=%5B"PAID"%5D'>
                            <i class="ri-shopping-bag-4-line"></i>
                            <h2>
                                {{number_format(\App\Models\Invoice::where('status','PAID')->count())}}
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
                        <a href='{{route('admin.ticket.index')}}?filter%5Bstatus%5D=%5B"PENDING"%5D'>
                            <i class="ri-customer-service-2-line"></i>
                            <h2>
                                {{number_format(\App\Models\Ticket::where('status','PENDING')->count())}}
                            </h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12 mb-3 p-0" id="visitor-container">
                <div class="card skewed-container">
                    <i class="ri-bar-chart-box-line skewed-icon"></i>
                    <div class="card-header">
                        {{__("Last month visits")}}
                    </div>
                    <div class="card-body">
                        <canvas id="visitor-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 p-0 pe-lg-2 mb-3">
                <div class="card skewed-container h-100">
                    <i class="ri-computer-line skewed-icon"></i>
                    <div class="card-header">
                        {{__("Last month visitors devices")}}
                    </div>
                    <div class="card-body">
                        <canvas id="visitor-device"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 p-0 ps-lg-2 mb-3">
                <div class="card skewed-container h-100">
                    <i class="ri-shopping-bag-3-line skewed-icon"></i>
                    <div class="card-header">
                        {{__("Last week orders")}}
                    </div>
                    <div class="card-body">
                        <canvas id="orders-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-content')
    <script>


        window.addEventListener('resize', function () {
            // window.vchart.resize(1,1);
            window.vchart.resize(null, 300);
        });

        window.addEventListener('load', function () {

            if (isPaintedChart) {
                return;
            }

            isPaintedChart = true;

            let visits = @json($visits);
            let ctx = document.getElementById('visitor-chart').getContext('2d');
            // document.getElementById('visitor-chart').setAttribute('width', document.querySelector('#visitor-container').clientWidth - 45);
            window.vchart = new window.chartjs(ctx, {
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
                    maintainAspectRatio: false,
                    resizeDelay: 1000,
                    // aspectRatio: 6,
                    layout: {
                        padding: 10,
                    },
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Website visits traffic'
                    }
                }
            });

            let ctx2 = document.getElementById('visitor-device').getContext('2d');
            // document.getElementById('visitor-chart').setAttribute('width', document.querySelector('#visitor-container').clientWidth - 45);
            window.dchart = new window.chartjs(ctx2, {
                // The type of chart we want to create
                type: 'pie', // also try bar or other graph types

                // The data for our dataset
                data: {
                    labels: ['All visitors','Desktop', 'Mobile / Tablet',],
                    datasets: [
                        {
                            label:"{{__('Devices')}}",
                            data: [{{$all_visitor}},{{$all_visitor - $mobiles_count}}, {{$mobiles_count}}],
                            backgroundColor: ['rgba(255,128,0,0.69)', 'rgba(255,0,54,0.56)','rgba(0,202,202,0.56)'],
                            hoverBackgroundColor: ['rgba(255,128,0,0.9)', 'rgba(255,0,54,0.9)','rgba(0,202,202,0.9)'],
                            borderWidth: 1,
                            borderColor: '#00000011'

                        }
                    ]
                },

                // Configuration options
                options: {
                    maintainAspectRatio: false,
                    resizeDelay: 1000,
                    // aspectRatio: 6,
                    layout: {
                        padding: 10
                    },
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Visitor device'
                    }
                }
            });

            let ctx3 = document.getElementById('orders-chart').getContext('2d');
            // document.getElementById('visitor-chart').setAttribute('width', document.querySelector('#visitor-container').clientWidth - 45);
            window.dchart = new window.chartjs(ctx3, {
                // The type of chart we want to create
                type: 'bar', // also try bar or other graph types

                // The data for our dataset
                data: {
                    labels: @json($week),
                    datasets: [
                        {
                            label: "{{__('Orders')}}",
                            backgroundColor: 'rgba(128,0,255,0.4)',
                            borderColor: 'rgba(140,0,255,0.6)',
                            data: @json($orders),
                            fill: true,
                        },
                        {
                            label: "{{__('Invoices')}}",
                            backgroundColor: 'rgba(255,0,0,0.4)',
                            borderColor: '#ff000099',
                            data: @json($invoices),
                            fill: true,
                        },
                    ]
                },

                // Configuration options
                options: {
                    maintainAspectRatio: false,
                    resizeDelay: 1000,
                    // aspectRatio: 6,
                    layout: {
                        padding: 10
                    },
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Visitor device'
                    }
                }
            });


            window.dispatchEvent(new Event('resize'));
        });

    </script>
@endsection
