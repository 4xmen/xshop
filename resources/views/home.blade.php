@extends('layouts.app')

@section('content')
    <div class="dash">
        <div class="dash__top">
            <section class="dash-card dash-welcome">
                <div class="dash-welcome__head">
                    <img src="{{auth()->user()->avatar()}}" class="avatar-x64" alt="avatar">
                    <div>
                        <span class="dash-welcome__eyebrow">
                            {{__("Welcome back")}}
                        </span>
                        <h4 class="dash-welcome__name">
                            {{auth()->user()->name}}
                        </h4>
                    </div>
                </div>
                <ul class="dash-welcome__stats">
                    <li class="dash-metric">
                        <h5 class="dash-metric__label">
                            {{__("Posts")}}
                        </h5>
                        <span class="dash-metric__value">
                            {{number_format(auth()->user()->posts()->count())}}
                        </span>
                        <div class="progress" role="progressbar" style="height: 3px">
                            <div class="progress-bar"
                                 style="width: {{auth()->user()->postsPercent()}}%"></div>
                        </div>
                    </li>
                    <li class="dash-metric">
                        <h5 class="dash-metric__label">
                            {{__("Products")}}
                        </h5>
                        <span class="dash-metric__value">
                            {{number_format(auth()->user()->products()->count())}}
                        </span>
                        <div class="progress" role="progressbar" style="height: 3px">
                            <div class="progress-bar bg-warning"
                                 style="width: {{auth()->user()->productsPercent()}}%"></div>
                        </div>
                    </li>
                    <li class="dash-metric">
                        <h5 class="dash-metric__label">
                            {{__("Comments")}}
                        </h5>
                        <span class="dash-metric__value">
                            {{number_format(auth()->user()->comments()->count())}}
                        </span>
                        <div class="progress" role="progressbar" style="height: 3px">
                            <div class="progress-bar bg-danger"
                                 style="width: {{auth()->user()->commentsPercent()}}%"></div>
                        </div>
                    </li>
                    <li class="dash-metric">
                        <h5 class="dash-metric__label">
                            {{__("Tickets")}}
                        </h5>
                        <span class="dash-metric__value">
                            {{number_format(auth()->user()->tickets()->count())}}
                        </span>
                        <div class="progress" role="progressbar" style="height: 3px">
                            <div class="progress-bar bg-success"
                                 style="width: {{auth()->user()->ticketsPercent()}}%"></div>
                        </div>
                    </li>
                </ul>
            </section>
            <section class="dash-card dash-action dash-action--orders">
                <a href='{{route('admin.invoice.index')}}?filter%5Bstatus%5D=%5B"PAID"%5D'>
                    <span class="dash-action__label">
                        {{__("Need process orders")}}
                    </span>
                    <i class="ri-shopping-bag-4-line"></i>
                    <h2>
                        {{number_format(\App\Models\Invoice::where('status','PAID')->count())}}
                    </h2>
                </a>
            </section>
            <section class="dash-card dash-action dash-action--tickets">
                <a href='{{route('admin.ticket.index')}}?filter%5Bstatus%5D=%5B"PENDING"%5D'>
                    <span class="dash-action__label">
                        {{__("Pending tickets")}}
                    </span>
                    <i class="ri-customer-service-2-line"></i>
                    <h2>
                        {{number_format(\App\Models\Ticket::where('status','PENDING')->count())}}
                    </h2>
                </a>
            </section>
        </div>

        <div id="visitor-container">
            <div class="card dash-chart dash-chart--wide">
                <div class="card-header">
                    <i class="ri-bar-chart-box-line"></i>
                    {{__("Last month visits")}}
                </div>
                <div class="card-body">
                    <canvas id="visitor-chart"></canvas>
                </div>
            </div>
        </div>

        <div class="dash__charts">
            <div class="card dash-chart">
                <div class="card-header">
                    <i class="ri-computer-line"></i>
                    {{__("Last month visitors devices")}}
                </div>
                <div class="card-body">
                    <canvas id="visitor-device"></canvas>
                </div>
            </div>
            <div class="card dash-chart">
                <div class="card-header">
                    <i class="ri-shopping-bag-3-line"></i>
                    {{__("Last week orders")}}
                </div>
                <div class="card-body">
                    <canvas id="orders-chart"></canvas>
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
                            backgroundColor: secondaryColor + '33',
                            borderColor: secondaryColor,
                            data: visits.subItem('count', 1),
                            fill: true,
                        },
                        {
                            label: "{{__('Visits')}}",
                            backgroundColor: primaryColor + '33',
                            borderColor: primaryColor,
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
                        // labels: {
                        //     fontColor: '#ff0000'
                        // }
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
                    labels: ['All visitors', 'Desktop', 'Mobile / Tablet',],
                    datasets: [
                        {
                            label: "{{__('Devices')}}",
                            data: [{{$all_visitor}}, {{$all_visitor - $mobiles_count}}, {{$mobiles_count}}],
                            backgroundColor: ['rgba(255,128,0,0.69)', 'rgba(255,0,54,0.56)', 'rgba(0,202,202,0.56)'],
                            hoverBackgroundColor: ['rgba(255,128,0,0.9)', 'rgba(255,0,54,0.9)', 'rgba(0,202,202,0.9)'],
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
                            backgroundColor: secondaryColor ,
                            borderColor: secondaryColor,
                            data: @json($orders),
                            fill: true,
                        },
                        {
                            label: "{{__('Invoices')}}",
                            backgroundColor: primaryColor,
                            borderColor: primaryColor ,
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
