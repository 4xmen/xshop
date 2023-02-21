<table class="table table-bordered table-striped table-hover table-border">
    <tr>
        <th>
            #
        </th>
        <th>
            {{__("Product")}}
        </th>
        <th>
            {{__("Order")}}
        </th>
        <th>
            {{__("Count")}}
        </th>
        <th>
            {{__("Price")}}
        </th>
    </tr>
    @foreach($invoice->products as $k => $p)
        <tr>
            <th>
                {{$k+1}}
                {{--                @if(strlen(trim($p->sku)) > 0)--}}
                {{--                    {{$p->sku}}--}}
                {{--                @else--}}
                {{--                    {{$p->id}}--}}
                {{--                @endif--}}
            </th>
            <td>
                {{$p->name}}
            </td>
            <td>
                @if($p->pivot->data == null)
                    {{__("Normal")}}
                @else
                    @foreach(json_decode(json_decode($p->pivot->data,true)['data'])  as $k => $pr)
                        @if(\App\Helpers\getPropLabel($k) !== '' && strlen(\App\Helpers\showMeta($k,$pr) ) > 0)
                            <div class="badge bg-secondary">
                                {{\App\Helpers\getPropLabel($k)}}:
                                {!! \App\Helpers\showMeta($k,$pr) !!}
                            </div>
                        @endif
                    @endforeach
                @endif
            </td>
            <td>
                {{$p->pivot->count}}
            </td>
            <td>
                {{number_format($p->pivot->price_total)}}
                {{config('app.currency_type')}}
            </td>
        </tr>
    @endforeach
</table>
<h5>
    {{__("Sub invoices items")}}
</h5>
@foreach($invoice->subInvoices as $inv)
    <table class="table table-bordered table-striped table-hover table-border">
        <tr>
            <th>
                #
            </th>
            <th>
                {{__("Product")}}
            </th>
            <th>
                {{__("Order")}}
            </th>
            <th>
                {{__("Count")}}
            </th>
            <th>
                {{__("Price")}}
            </th>
        </tr>
        @foreach($inv->products as $k => $p)
            <tr>
                <th>
                    {{$k+1}}
                    {{--                @if(strlen(trim($p->sku)) > 0)--}}
                    {{--                    {{$p->sku}}--}}
                    {{--                @else--}}
                    {{--                    {{$p->id}}--}}
                    {{--                @endif--}}
                </th>
                <td>
                    {{$p->name}} <a href="{{route('customer.invoice',$inv->hash)}}">({{__($inv->status)}})</a>
                </td>
                <td>
                    @if($p->pivot->data == null)
                        {{__("Normal")}}
                    @else
                        @foreach(json_decode(json_decode($p->pivot->data,true)['data'])  as $k => $pr)
                            @if(\App\Helpers\getPropLabel($k) !== '' && strlen(\App\Helpers\showMeta($k,$pr) ) > 0)
                                <div class="badge bg-secondary">
                                    {{\App\Helpers\getPropLabel($k)}}:
                                    {!! \App\Helpers\showMeta($k,$pr) !!}
                                </div>
                            @endif
                        @endforeach
                    @endif
                </td>
                <td>
                    {{$p->pivot->count}}
                </td>
                <td>
                    {{number_format($p->pivot->price_total)}}
                    {{config('app.currency_type')}}
                </td>
            </tr>
        @endforeach
    </table>
@endforeach
<div class="row">

    <div class="col-md-8" style="width: 60%">
        <table class="table table-bordered table-striped table-hover table-border">
            <tr>
                <th>
                    {{__("Title")}}
                </th>
                <th>
                    {{__("Price")}}
                </th>
            </tr>
            @if($invoice->transport != null)

                <tr>
                    <th>
                        {{__("Transport method")}}:
                    </th>
                    <td>
                    {{$invoice->transport->title}}

                </tr>
                <tr>
                    <td>
                        {{__("Transport price")}}:
                    </td>
                    <td>

                        {{number_format($invoice->transport->price)}}
                        {{config('app.currency_type')}}
                    </td>
                </tr>
            @endif
            <tr>
                <td>
                    {{__("Tax")}}
                </td>
                <td>
                    0
                    {{config('app.currency_type')}}
                </td>
            </tr>
            <tr>
                <td>
                    {{__("Pay by credit")}}
                </td>
                <td>
                    {{number_format($invoice->credit_price)}}
                    {{config('app.currency_type')}}
                </td>
            </tr>
            <tr>
                <td>
                    {{__("Discount")}}
                </td>
                <td>
                    @if($invoice->discount == null)
                        0
                        {{config('app.currency_type')}}
                    @else
                        {{$invoice->dicsount->discount}}
                        {{config('app.currency_type')}}/%
                    @endif

                </td>
            </tr>
            <tr>
                <th>
                    {{__("Sum")}}
                </th>
                <th>
                    {{number_format($invoice->total_price)}}
                    {{config('app.currency_type')}}
                </th>
            </tr>
        </table>

    </div>
    <div class="col-md-4" style="width: 40%">

        @if($invoice->status===\App\Models\Invoice::PENDING || $invoice->status===\App\Models\Invoice::FAILED)
            <hr>
            <h5 class="text-center">
                {{__("Payment price:")}}
                {{number_format($invoice->total_price - $invoice->credit_price)}}
            </h5>
            <hr>
            <div>
                <a href="{{route('redirect.bank',['invoice'=>$invoice->hash,'gateway'=>config('app.pay_gate')])}}"
                   class="btn btn-success w-100">
                    <i class="far fa-credit-card"></i>
                    &nbsp;
                    پرداخت آنلاین
                </a>
            </div>
            @if(auth('customer')->check() && auth('customer')->user()->credit > 0)
                <hr>
                <h5 class="text-center">
                    {{__("Pay by credit")}}: {{number_format(auth('customer')->user()->credit)}} {{config('app.currency_type')}}
                </h5>
                <a href="{{route('credit',$invoice->hash)}}"
                   class="btn btn-secondary w-100">
                    <i class="fa fa-credit-card"></i>
                    &nbsp;
                    پرداخت اعتباری
                    (
                    @if($invoice->total_price <  $invoice->credit_price)
                        {{ number_format($invoice->credit_price) }}
                    @else
                        {{number_format($invoice->total_price)}}
                    @endif
                    {{config('app.currency_type')}} )
                </a>
            @endif
        @endif
        @if($invoice->subInvoices->count() > 0)
                <hr>
            <div class="alert alert-danger">
                مبلغ فوق فقط برای این صورت حساب است، سایر صورت حساب ها باید جداگانه تسویه شود
            </div>
        @endif
    </div>
</div>
