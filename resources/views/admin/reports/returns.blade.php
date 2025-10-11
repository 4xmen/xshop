@extends('layouts.app')

@section('content')
    <div class="row">

        <form action="" method="get">
            @foreach (request()->query() as $key => $value)
                @if ($key !== 'limit' && $key !== 'start_date' && $key !== 'end_date')
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <div class="row">
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="limit">
                            {{__("Limit")}}
                        </label>
                        <input type="number" id="limit" name="limit" value="{{request()->input('limit',30)}}" placeholder="{{__("Limit")}}"
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
            <table class="table-list">
                <tr>
                    <th >
                        {{__("Count")}}
                    </th>
                    <th>
                        {{__("Value")}}
                    </th>
                    <th>
                        {{__("Average")}}
                    </th>
                    <th>
                        {{__("Reason")}}
                    </th>
                </tr>

                @foreach($data as $item)
                    <tr>
                        <td >
                            {{$item->return_count}}
                        </td>
                        <td>
                            {{number_format($item->return_value)}} {{config('app.currency.symbol')}}
                        </td>
                        <td>
                            {{number_format($item->avg_return,0)}} {{config('app.currency.symbol')}}
                        </td>
                        <td>
                            {{($item->common_reasons)}}
                        </td>
                    </tr>

                @endforeach
                    <tr>
                        <th colspan="2">
                            {{__("Impact")}}
                        </th>
                        <td colspan="2">
                            {{number_format($impact)}} {{config('app.currency.symbol')}}
                        </td>
                    </tr>
            </table>
        </div>
    </div>
@endsection
@section('js-content')
    <script>

    </script>
@endsection
