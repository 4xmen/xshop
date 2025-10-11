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
                        <input type="number" id="limit" name="limit" value="{{request()->input('limit',10)}}" placeholder="{{__("Limit")}}"
                               class="form-control">
                    </div>
                </div>
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="low-tr">
                            {{__("Low threshold")}}
                        </label>
                        <input type="number" id="low-tr" name="low_threshold" value="{{request()->input('low_threshold',10)}}" placeholder=" {{__("Low threshold")}}" class="form-control">
                    </div>
                </div>
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="pro_name">
                            {{__("Product name")}}
                        </label>
                        <input type="text" id="pro_name" name="q" value="{{request()->input('q','')}}" placeholder="{{__("Product name")}}" class="form-control">
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
                        {{__("ID")}}
                    </th>
                    <th>
                        {{__("Name")}}
                    </th>
                    <th>
                        {{__("Stock quantity")}}
                    </th>
                    <th>
                        {{__("Quantities")}}
                    </th>
                </tr>

                @foreach($data as $item)
                    <tr>
                        <td >
                            {{$item->id}}
                        </td>
                        <td>
                            {{($item->name)}}
                        </td>
                        <td>
                            {{number_format($item->stock_quantity)}}
                        </td>
                        <td>
                            -
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
