<section class='LianaInvoice'>
    <div class="p-3">

        <div class="row  mb-4">
            <div class="col-10">
                <div class="overflow-hidden">
                    <img src="{{asset('upload/images/logo.png')}}" class="float-end liana-logo" alt="">

                    <h3 class="mt-3">
                        {{config('app.name')}}
                    </h3>
                </div>
                {{--        @php($invoice == \App\Models\Invoice::first())--}}
                <div class="row">
                    <div class="col">
                        {{__("Date")}}: {{$invoice->created_at->ldate('Y-m-d')}}
                    </div>
                    <div class="col-7 text-center">
                        {{__("Customer")}}: {{$invoice->customer->name}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        {{__("ID")}}: {{$invoice->hash}} ({{$invoice->status}})
                    </div>
                    <div class="col-7 text-center">
                        {{__("Customer mobile")}}: {{$invoice->customer->mobile}}
                    </div>
                </div>
            </div>
            <div class="col-2 text-center">
                <img src="{{$qr->render(route('client.invoice',$invoice->hash))}}" alt="qr code"
                     class="qr-code">
            </div>
        </div>

        <table class="table table-striped align-middle table-bordered text-center">
            <tr>
                <th>
                    #
                </th>
                <th>
                    {{__("Product")}}
                </th>
                <th>
                    {{__("Count")}}
                </th>
                <th>
                    {{__("Quantity")}}
                </th>
                <th>
                    {{__("Price")}}
                </th>
            </tr>
            @foreach($invoice->orders as $k => $order)
                <tr>
                    <td>
                        {{$k + 1}}
                    </td>
                    <td>
                        {{$order->product->name}}
                    </td>
                    <td>
                        {{number_format($order->count)}}
                    </td>
                    <td>
                        @if( ($order->quantity->meta??null) == null)
                            -
                        @else
                            @foreach($order->quantity->meta as $m)
                                <span>
                                {{$m->human_value}}
                            </span>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        {{number_format($order->price_total)}}
                    </td>
                </tr>
            @endforeach

            <tr>
                <td>
                    -
                </td>
                <td>
                    {{__("Transport")}}
                    {{number_format($invoice->transport_price)}}
                </td>
                <td colspan="2">
                    {{__("Total price")}}
                    {{number_format($invoice->total_price)}}
                </td>
                <td colspan="2">
                    {{__("Orders count")}}: ({{number_format($invoice->count)}})
                </td>
            </tr>
        </table>

        <div class="inv-footer">
            <p>
                {{$invoice->desc}}
            </p>
            <hr>
            {{__("Address")}}:
            {{$invoice->address->state->name}}, {{$invoice->address->city->name}}, {{$invoice->address->address}}
            , {{$invoice->address->zip}}
            @if(trim(getSetting($data->area_name.'_'.$data->part.'_desc')) != '')
                <hr>
                {!! getSetting($data->area_name.'_'.$data->part.'_desc') !!}
            @endif
        </div>
        <div class="no-print btn btn-primary mt-2 w-100" onclick="window.print()">
            {{__("Print")}}
        </div>
    </div>
</section>
