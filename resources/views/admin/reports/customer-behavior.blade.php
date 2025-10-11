@extends('layouts.app')

@section('content')
    <div class="row">

        <form action="" method="get">
            @foreach (request()->query() as $key => $value)
                @if ($key !== 'limit' && $key !== 'q' && $key !== 'start_date' && $key !== 'end_date')
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <div class="row">
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="limit">
                            {{__("Limit")}}
                        </label>
                        <input type="number" id="limit" name="limit" value="{{request()->input('limit',10)}}" placeholder="{{__("Limit")}}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="q">
                            {{__("Search customer name & mobile")}}
                        </label>
                        <input type="text" id="q" name="q" value="{{request()->input('q','')}}" placeholder="{{__("Search query")}}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="start_date">
                            {{__("Start date")}}
                        </label>
                        <vue-datetime-picker-input
                            xid="start_date" xname="start_date" xtitle="{{__("Start date")}}"  @if(app()->getLocale() != 'fa')  def-tab="1" xshow="date"  @else xshow="pdate"  @endif
                        :xvalue="{{request()->input('start_date',strtotime('-30 days'))}}"
                        ></vue-datetime-picker-input>
                    </div>
                </div>
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="end_date">
                            {{__("Start date")}}
                        </label>
                        <vue-datetime-picker-input
                            xid="end_date" xname="end_date" xtitle="{{__("End date")}}"  @if(app()->getLocale() != 'fa')  def-tab="1" xshow="date"  @else xshow="pdate"  @endif
                        :xvalue="{{request()->input('end_date',time())}}"
                        ></vue-datetime-picker-input>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <button class="btn btn-secondary">
                        {{__("Apply")}}
                    </button>
                </div>
            </div>
        </form>

        <div class="p-3">
            <h3>
                {{__("Customers")}}
            </h3>
            <table class="table-list">
                <tr>
                    <th style="width: auto">
                        {{__("ID")}}
                    </th>
                    <th>
                        {{__("Name")}}
                    </th>
                    <th>
                        {{__("Information")}}
                    </th>
                    <th>
                        {{__("Return rate")}}
                    </th>
                    <th>
                        {{__("Invoices")}}
                    </th>
                </tr>

                @foreach($customers as $item)
                    <tr>
                        <td style="width: auto">
                            {{$item->id}}
                        </td>
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            <span class="customer-{{$item->segment}}">
                                {{$item->segment}}
                            </span>
                        </td>
                        <td>
                            {{number_format($item->return_rate)}}
                        </td>
                        <td>

                        </td>
                    </tr>

                @endforeach
            </table>

            <hr>
            <h4>
                {{__("Peak times")}}
            </h4>
            <table class="table table-striped">
                <tr>
                    <th>
                        {{__("Hour")}}
                    </th>
                    <th>
                        {{__("Count")}}
                    </th>
                </tr>
                @foreach($peakTimes as $peak)
                    <tr>
                        <td>
                            {{sprintf("%02d",$peak->hour)}}
                        </td>
                        <td>
                            {{number_format($peak->count)}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
@section('js-content')
    <script>

    </script>
@endsection
