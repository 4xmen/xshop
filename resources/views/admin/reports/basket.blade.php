@extends('layouts.app')

@section('content')
    <div class="row">

        <form action="" method="get">
{{--            @foreach (request()->query() as $key => $value)--}}
{{--                @if ($key !== 'limit' && $key !== 'start_date' && $key !== 'end_date')--}}
{{--                <input type="hidden" name="{{ $key }}" value="{{ $value }}">--}}
{{--                @endif--}}
{{--            @endforeach--}}
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
                        #
                    </th>
                    <th>
                        {{__("Product")}}
                    </th>
                    <th>
                        {{__("Related products")}}
                    </th>
                    <th>
                        {{__("Frequency")}}
                    </th>
                </tr>

                @foreach($data as $k => $item)
                    <tr>
                        <td >
                            {{$k}}
                        </td>
                        <td>
                            {{$item['product1']}}
                        </td>
                        <td>
                            {{$item['product2']}}
                        </td>
                        <td>
                            {{number_format($item['frequency'])}}
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
