@extends('starter-kit::layouts.adminlayout')
@section('page_title')
    {{__("Comments")}}
    -
@endsection
@section('content')
    <div class="container">

        @include('starter-kit::component.err')
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        {{__("User")}}
                    </th>
                    <th>
                        {{__("Action")}}
                    </th>
                    <th>
                        {{__("Information")}}
                    </th>
                    <th>
                        {{__("Date")}}
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>
                            {{$log->id}}
                        </td>
                        <td>
                            {{$log->user->name}}
                        </td>
                        <td>
                            {{__("$log->action")}}
                        </td>
                        <td>
                            {{__($log->loggable_type)}}|
                            {{$log->loggable_id}}
                        </td>
                        <td>
                            {{$log->persianDate()}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        <div class="text-center pt-3">
            {{$logs->links()}}
        </div>
    </div>
@endsection
