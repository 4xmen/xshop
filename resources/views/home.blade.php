@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 p-0 pe-md-2 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 text-center">
                                <img src="{{asset('panel/images/xshop-logo.svg')}}" class="avatar-x64" alt="">
                            </div>
                            <div class="col-9">
                                {{__("Welcome bak")}}
                                <h4>
                                    {{auth()->user()->name}}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-0 ps-md-2 mb-3">
                <div class="card">
                    <div class="card-header">
                        lorem
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Aliquam aspernatur, commodi consequatur deleniti dolor,
                        dolore ducimus ipsa laudantium magni natus nemo neque odit
                        officia perferendis provident suscipit ullam voluptas voluptate?
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-3 p-0" id="visitor-container">
                <div class="card">
                    <div class="card-header">
                        {{__("last month visits")}}
                    </div>
                    <div class="card-body">
                        <canvas id="visitor-chart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        lorem
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Aliquam aspernatur, commodi consequatur deleniti dolor,
                        dolore ducimus ipsa laudantium magni natus nemo neque odit
                        officia perferendis provident suscipit ullam voluptas voluptate?
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        lorem
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Aliquam aspernatur, commodi consequatur deleniti dolor,
                        dolore ducimus ipsa laudantium magni natus nemo neque odit
                        officia perferendis provident suscipit ullam voluptas voluptate?
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        lorem
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Aliquam aspernatur, commodi consequatur deleniti dolor,
                        dolore ducimus ipsa laudantium magni natus nemo neque odit
                        officia perferendis provident suscipit ullam voluptas voluptate?
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        lorem
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Aliquam aspernatur, commodi consequatur deleniti dolor,
                        dolore ducimus ipsa laudantium magni natus nemo neque odit
                        officia perferendis provident suscipit ullam voluptas voluptate?
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        lorem
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Aliquam aspernatur, commodi consequatur deleniti dolor,
                        dolore ducimus ipsa laudantium magni natus nemo neque odit
                        officia perferendis provident suscipit ullam voluptas voluptate?
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        lorem
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Aliquam aspernatur, commodi consequatur deleniti dolor,
                        dolore ducimus ipsa laudantium magni natus nemo neque odit
                        officia perferendis provident suscipit ullam voluptas voluptate?
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-header">
                        lorem
                    </div>
                    <div class="card-body">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Aliquam aspernatur, commodi consequatur deleniti dolor,
                        dolore ducimus ipsa laudantium magni natus nemo neque odit
                        officia perferendis provident suscipit ullam voluptas voluptate?
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
