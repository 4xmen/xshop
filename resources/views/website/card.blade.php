@extends('website.layout')
@section('title')
    {{__("Shopping card")}} -
@endsection
@section('content')
    @if((count($pros) + count($qpros)) > 0)
        <div id="main-conetent">
            <section id="product" class="wow zoomInUp" data-wow-delay=".5">
                <div class="container" style="min-height: 100vh">
                    @include('starter-kit::component.err')
                    @if (!Auth::guard('customer')->check())
                        <div class="alert alert-warning">
                            شما ثبت نام نکرده اید.
                            <br>
                            لطفا پیش از ادامه ثبت نام کنید یا وارد شوید
                        </div>
                    @endif
                    <form action="{{route('invoice.create')}}" method="post">
                        @csrf
                        <div class="text-center" id="card">
                            <table class="table table-bordered table-striped table-hover"
                                   id="card-table">
                                <tr>
                                    <th>
                                        {{__("Image")}}
                                    </th>
                                    <th colspan="2">
                                        {{__("Name")}}
                                    </th>
                                    <th colspan="2">
                                        {{__("Quantity")}}
                                    </th>
                                    <th colspan="2">
                                        {{__("Price")}}
                                    </th>
                                    <th colspan="2">
                                        {{__("Count")}}
                                    </th>
                                    <th>
                                        -
                                    </th>
                                </tr>
                                @php($tot = 0)
                                @foreach ($pros as $pro)
                                    <tr>
                                        <td>

                                            <a href="{{route('product',$pro->slug)}}">
                                                <img src="{{$pro->thumbUrl()}}" class="img-64" alt="">
                                            </a>
                                        </td>
                                        <td colspan="2">
                                            {{$pro->name}}
                                            <input type="hidden" name="products[]" value="{{$pro->id}}">
                                        </td>
                                        <td colspan="2">
                                            @if($pro->quantities()->sum('count') > 0)
                                                @foreach($pro->quantities as $q)
                                                    @if($q->count > 0)
                                                        @include('component.card-quantity',compact('q','pro'))
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="active" data-count="{{$pro->stock_quantity}}"></span>
                                                @foreach(\App\Helpers\getPriceableMeta($pro) as $k => $meta)
                                                    <div class="meta">
                                                        {{\App\Helpers\getPropLabel($k)}}
                                                        @if($k == 'color')
                                                            {!! \App\Helpers\showMeta($k,$meta) !!}
                                                        @else
                                                            <b>
                                                                {!! \App\Helpers\showMeta($k,$meta) !!}
                                                            </b>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td colspan="2" class="price-td" data-price="{{$pro->getPurePrice()}}">
                                            @if($pro->getPurePrice() == 0)
                                                {{__("We call you about price soon.")}}
                                            @else
                                                <span class="price">
                                                {{number_format($pro->getPurePrice())}}
                                            </span>
                                                {{config('app.currency_type')}}
                                            @endif
                                            @php($tot = $tot + $pro->getPurePrice())
                                        </td>
                                        <td colspan="2">
                                            <div class="product-count">
                                                <div class="btn btn-info count-inc">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                                <input type="number" data-stock="{{$pro->stock_quantity}}"
                                                       max="{{$pro->stock_quantity}}" name="count[{{$pro->id}}]"
                                                       min="1"
                                                       data-price="{{str_replace(',','',$pro->getPurePrice())}}"
                                                       class="form-control product-count"
                                                       value="1">
                                                <div class="btn btn-info count-dec">
                                                    <i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('card.rem',$pro->slug)}}" class="btn btn-outline-danger">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                                @foreach ($qpros as $xkey => $qpro)
                                    <tr>
                                        <td>

                                            <a href="{{route('product',$qpro->product->slug)}}">
                                                <img src="{{$qpro->product->thumbUrl()}}" class="img-64" alt="">
                                            </a>
                                        </td>
                                        <td colspan="2">
                                            {{$qpro->product->name}}
                                        </td>
                                        <td colspan="2">
                                            @php($data = json_decode($qpro->data))
                                            <span class="badge badge-inverse" style="background: {{$data->color}};">
                                            <b>
                                                {{\App\Helpers\getColorName($data->color)}}
                                            </b>
                                        </span>
                                            <span class="badge bg-dark">
                                             {{$data->size}}
                                        </span>
                                        </td>
                                        <td colspan="2" class="price-td" data-price="{{$qpro->price}}">
                                            @if($qpro->price == 0)
                                                {{__("We call you about price soon.")}}
                                            @else
                                                <span class="price">
                                                {{number_format($qpro->price)}}
                                            </span>
                                                {{config('app.currency_type')}}
                                            @endif
                                            @php($tot = $tot + $qpro->price)
                                        </td>
                                        <td colspan="2">
                                            <div class="product-count">
                                                <div class="btn btn-info count-inc">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                                <input type="number" data-stock="{{$qpro->count}}" max="{{$qpro->count}}"
                                                       name="qcount[{{$qpro->id}}]"
                                                       min="1"
                                                       data-price="{{$qpro->price}}"
                                                       class="form-control product-count"
                                                       value="{{$counts[$xkey]}}">
                                                <div class="btn btn-info count-dec">
                                                    <i class="fa fa-minus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{route('card.remq',$qpro->id)}}" class="btn btn-outline-danger">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach
                                <tr>
                                    <td colspan="4" class="text-left">
                                        <label class="desc">
                                            {{__("Description")}}
                                        </label>
                                        <br>
                                        <textarea
                                            placeholder="{{__("If you have any description about your order write here...")}}"
                                            name="desc" class="form-control" id="desc" rows="2"></textarea>
                                    </td>
                                    <td colspan="4">
                                        {{__("Total amount")}}
                                        <hr>
                                        <span id="total-card">
                                        {{number_format($tot)}}
                                    </span>
                                        {{config('app.currency_type')}}
                                    </td>
                                    <td colspan="2">
                                        <label class="text-start d-block">
                                            {{__("Discount code")}}
                                        </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="discount-code" name="discount"
                                                       placeholder="{{__("Discount code")}}">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="btn btn-primary" id="discount" data-discount="{}"
                                                     data-url="{{route('discount')}}">
                                                    {{__("Check discount")}}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            </table>
                        </div>

                        @if(auth('customer')->user()->colleague??null)
                            <textarea name="address_alt" class="form-control mb-2" rows="4"
                                      placeholder="{{__("Alternative address")}}">{{old('address_alt')}}</textarea>
                            <hr>
                        @endif

                        @if(count($transports) > 0)
                            <div class="card mb-2">
                                <h4 class="card-header">
                                    {{__("Transport method")}}
                                </h4>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach($transports as $k=> $t)
                                            <li class="list-group-item">
                                                <input id="tns{{$k}}" type="radio" name="transport_id"
                                                       data-price="{{$t->price}}"
                                                       value="{{$t->id}}"
                                                       onclick="$('.product-count').change();"
                                                       @if ($t->is_default) checked
                                                       @endif class="form-check-input transport">
                                                <label for="tns{{$k}}" class="form-check-label">
                                                    &nbsp;
                                                    {{$t->title}}
                                                </label>
                                                @if(strlen($t->description) > 1)
                                                    <p class="preline alert alert-info mt-1">{{$t->description}} <span
                                                            class="float-end">@if($t->price > 0){{number_format($t->price)}} @else {{__("Free")}} @endif</span>
                                                    </p>
                                                @endif
                                            </li>
                                        @endforeach
                                        @if(count($resevers) > 0)
                                            @foreach($resevers as $k=> $r)
                                                <li class="list-group-item">
                                                    <input id="rv{{$k}}" type="radio" name="invoice_id"
                                                           data-price="0"
                                                           value="{{$r->id}}"
                                                           class="form-check-input reserve">
                                                    <label for="rv{{$k}}" class="form-check-label">

                                                        &nbsp;
                                                        اضافه شدن به سفارش با مبلغ:
                                                        <b>
                                                            ({{number_format($r->total_price)}})
                                                        </b>

                                                        و به آدرس:
                                                        <b>
                                                            {{$r->customer->address}}
                                                        </b>
                                                        و زمان سفارش:
                                                        <b>
                                                            {{$r->created_at->diffForHumans()}}
                                                        </b>
                                                    </label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="p-5 py-3" id="resv">
                                    <div class="form-check form-switch">
                                        <input name="reserve" class="form-check-input" type="checkbox" role="switch"
                                               id="flexSwitchCheckDefault">
                                        <label class="form-check-label"
                                               for="flexSwitchCheckDefault">{{__("Reserve order for :H hours",['H'=>\App\Helpers\getSetting('reserve')])}}</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="alert alert-info">
                            <h2>
                                {{__("Final amount")}}:
                                <div class="float-end">
                               <span id="last-price">
                                    {{number_format($tot)}}
                               </span>
                                    {{config('app.currency_type')}}
                                </div>
                            </h2>
                            <hr>
                            &nbsp;@if (Auth::guard('customer')->check())
                                خریدار:
                                {{auth('customer')->user()->name}} -
                                موبایل: {{auth('customer')->user()->mobile}}
                                <hr>
                                <h5>
                                    {{__("choose addrress")}}:
                                </h5>
                                <div class="p-2">
                                    <label>
                                        <input type="radio" name="address_id" value="0" checked>
                                        {{auth('customer')->user()->address}} - کد
                                        پستی: {{auth('customer')->user()->postal_code??'X'}}
                                    </label>
                                </div>
                                @foreach(auth('customer')->user()->addresses as $ad)

                                    <div class="p-2">
                                        <label>
                                            <input type="radio" name="address_id" value="{{$ad->id}}">
                                            {{$ad->address}}
                                        </label>
                                    </div>
                                @endforeach
                                @if(strlen(auth('customer')->user()->address) < 10)
                                    تا زمانی که اطلاعات خود را تکمیل نکنید امکان ثبت سفارش ندارید
                                    <br>
                                    <a href="{{route('customer')}}" class="btn btn-warning">
                                        تکمیل اطلاعات
                                    </a>
                                @else
                                <button type="submit" class="btn btn-success float-end me-3 ms-3">
                                    <i class="far fa-credit-card"></i>
                                    پرداخت از درگاه های آنلاین
                                </button>
                                <button type="submit" class="btn btn-secondary  float-end " name="nopay" value="no-payment">
                                    <i class="far fa-credit-card"></i>
                                    ثبت سفارش پرداخت اعتباری + آنلاین
                                </button>
                                <br>
                                <br>
                                @endif
                                &nbsp;@else
                                {{__("Register or login to complete purchase")}}
                                <a href="{{route('sign')}}">
                                    <i class="fa fa-user"></i>
                                    <span>
                                                ثبت نام یا ورود
                                </span>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </section>
        </div>
    @else
        <div class="container text-center">
            <h2 class="my-5">
                سبد خرید شما خالی است
            </h2>
        </div>
    @endif
@endsection
