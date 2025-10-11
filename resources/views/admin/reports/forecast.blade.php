@extends('layouts.app')

@section('content')
    <div class="row">


        <div class="p-3">
            <table class="table-list">
                <tr>
                    <th >
                        {{__("Month")}}
                    </th>
                    <th>
                        {{__("Predicted")}}
                    </th>
                </tr>

                @foreach($data as $item)
                    <tr>
                        <td >
                            {{$item['month']}}
                        </td>
                        <td>
                            {{number_format($item['predicted'])}} {{config('app.currency.symbol')}}
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
