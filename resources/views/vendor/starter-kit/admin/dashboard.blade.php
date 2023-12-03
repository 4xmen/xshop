@extends('starter-kit::layouts.adminlayout')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">
                    <a class="btn btn-dark float-start" href="{{route('admin.home.nav',[$ny,$nm])}}">
                        {{__("Next")}}
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    {{$dt->PDate('Y F',$time)}}
                    <a class="btn btn-dark float-end" href="{{route('admin.home.nav',[$py,$pm])}}">
                        <i class="fa fa-arrow-right"></i>
                        {{__("Previous")}}
                    </a>
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-bordered text-center">
                    <tr>
                        <th>
                            {{__("Saturday")}}
                        </th>
                        <th>
                            {{__("Sunday")}}
                        </th>
                        <th>
                            {{__("Monday")}}
                        </th>
                        <th>
                            {{__("Tuesday")}}
                        </th>
                        <th>
                            {{__("Wednesday")}}
                        </th>
                        <th>
                            {{__("Thursday")}}
                        </th>
                        <th>
                            {{__("Friday")}}
                        </th>
                    </tr>
                    <tr>
                        @if($dt->PDate('w',$start) > 0)
                            <td colspan="{{$dt->PDate('w',$start)}}"></td>
                        @endif
                        @php
                            $j = $dt->PDate('w',$start);
                            $today = $dt->Pdate('Y-m-d');
                        @endphp
                        @for ($i = $start; $i <= $end; $i+=86400)
                            @php
                                $j++;
                            @endphp
                            <td class="@if($today == $dt->PDate('Y-m-d',$i)) date-current @endif">
                                {{$dt->PDate('d',$i)}}
                            </td>
                            @if ($j % 7 == 0)
                    </tr>
                    <tr>
                        @endif
                        @endfor
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js-content')

    <div class="container mb-5">
        <div class="row mt-3">
            <div class="col-md-6">
                <div>
                    <div>
                        {!! $chartjs->render() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <div>
                        {!! $chartjs2->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
