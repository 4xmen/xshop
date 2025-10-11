@extends('layouts.app')

@section('content')
    <div class="row">

        <form action="" method="get">
            @foreach (request()->query() as $key => $value)
                @if ( $key !== 'start_date' && $key !== 'end_date')
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach
            <div class="row">
                <div class="col-lg mt-2">
                    <div class="form-group">
                        <label for="start_date">
                            {{__("Start date")}}
                        </label>
                        <vue-datetime-picker-input
                           xid="start_date" xname="start_date" xtitle="{{__("Start date")}}"  @if(app()->getLocale() != 'fa')  def-tab="1" xshow="date"  @else xshow="pdate"  @endif
                          :xvalue="{{request()->input('start_date', strtotime('first day of January this year') + 0)}}"
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

        <div class="report-grid mt-4">
            <div class="report-btn">
                <i class="ri-coins-line"></i>
                {{__("Gross revenue")}}:
                <b class="ms-4 text-primary fs-3">
                    {{number_format($data['gross_revenue'])}} {{config('app.currency.symbol')}}
                </b>
            </div>
            <div class="report-btn">
                <i class="ri-align-bottom"></i>
                {{__("Costs")}}:
                <b class="ms-4 text-primary fs-3">
                    {{number_format($data['costs'])}} {{config('app.currency.symbol')}}
                </b>
            </div>
            <div class="report-btn">
                <i class="ri-hand-coin-line"></i>
                {{__("Net profit")}}:
                <b class="ms-4 text-primary fs-3">
                    {{number_format($data['net_profit'])}} {{config('app.currency.symbol')}}
                </b>
            </div>
            <div class="report-btn">
                <i class="ri-no-credit-card-line"></i>

                {{__("Debts")}}:
                <b class="ms-4 text-primary fs-3">
                    {{number_format($data['debts'])}} {{config('app.currency.symbol')}}
                </b>
            </div>
        </div>
    </div>
@endsection
@section('js-content')
    <script>

    </script>
@endsection
