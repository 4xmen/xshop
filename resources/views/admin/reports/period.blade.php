@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md">
            <a href="?period=daily" class="col-md btn btn-secondary w-100">
                {{__("Daily")}}
            </a>
        </div>
        <div class="col-md">
            <a href="?period=monthly" class=" btn btn-secondary w-100">
                {{__("Monthly")}}
            </a>
        </div>
        <form action="" method="get">
            @foreach (request()->query() as $key => $value)
                @if ($key !== 'limit')
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <div class="row">
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="limit">
                            {{__("Limit")}}
                        </label>
                        <input type="number" id="limit" name="limit" value="{{request()->input('limit',50)}}" placeholder="{{__("Limit")}}"
                               class="form-control">
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
                    <th style="width: auto">
                        {{__("Date")}}
                    </th>
                    <th>
                        {{__("Revenue")}}
                    </th>
                    <th>
                        {{__("Order count")}}
                    </th>
                    <th>
                        {{__("Average basket value")}}
                    </th>
                </tr>

                @foreach($data as $item)
                    <tr>
                        <td style="width: auto">
                            {{\Carbon\Carbon::createFromDate($item->date)->ldate('Y/m/d')}}
                        </td>
                        <td>
                            {{number_format($item->revenue)}} {{config('app.currency.symbol')}}
                        </td>
                        <td>
                            {{number_format($item->order_count)}}
                        </td>
                        <td>
                            {{number_format($item->avg_basket_value)}} {{config('app.currency.symbol')}}
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
