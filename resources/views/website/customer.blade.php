@extends('website.layout')
@section('title')
    {{__("Customer profile")}} -
@endsection
@section('content')
    <div id="main-conetent">
        <div class="container mt-3">
            @if(Auth::guard('customer')->user()->name == null || Auth::guard('customer')->user()->name == '')
                <div class="alert alert-warning">
                    {{__("Dear customer, Please complete your information")}}
                </div>
            @else
                <div class="alert alert-info">
                    {{__("Hello")}}, {{Auth::guard('customer')->user()->name}}
                </div>
            @endif

            @if (\App\Helpers\cardCount() > 0)
                <div class="alert alert-success overflow-hidden">
                    {{__("You have got :count products in your basket, Could you complete your purchase?",['count'=>\App\Helpers\cardCount()])}}
                    <br>
                    <a href="{{route('card.show')}}" class="btn btn-success w-50 d-block m-auto mt-2">
                        {{__("Complete your purchase")}}
                    </a>
                </div>
            @endif
            @include('starter-kit::component.err')
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="position-sticky" style="top:100px;">
                        <ul class="list-group" id="profile-tab">
                            <li class="list-group-item active" data-id="#profile">
                                {{__("Profile")}}
                            </li>
                            <li class="list-group-item" data-id="#invoices">
                                {{__("Your invoices")}}
                            </li>
                            <li class="list-group-item" data-id="#tickets">
                                {{__("Tickets")}}
                            </li>
                            <li class="list-group-item" data-id="#new">
                                {{__("Send new ticket")}}
                            </li>
                            @if(!(auth('customer')->user()->colleague??null))
                                <li class="list-group-item" data-id="#req">
                                    {{__("Application request")}}
                                </li>
                            @endif
                            <li class="list-group-item" data-id="#crt">
                                {{__("Credit")}}
                            </li>
                            <li class="list-group-item" data-id="#favs">
                                {{__("Favorites")}}
                            </li>
                            <li class="list-group-item" data-id="#address">
                                {{__("Addresses")}}
                            </li>
                            <li class="list-group-item">
                                <a href="{{route('logout')}}">
                                    {{__("Logout")}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-10 col-md-9">
                    <div id="profile" class="active profile-tab">
                        <form class="p-3" method="post" action="{{route('profile')}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="name">
                                            {{__('Name')}}
                                        </label>
                                        <input name="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="{{__('Name')}}"
                                               value="{{old('name',$customer->name??null)}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <div class="form-group">
                                        <label for="email">
                                            {{__('Email')}}
                                        </label>
                                        <input name="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="{{__('Email')}}"
                                               value="{{old('email',$customer->email??null)}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group">
                                        <label for="postal_code">
                                            {{__('postal_code')}}
                                        </label>
                                        <input name="postal_code" type="text"
                                               class="form-control @error('postal_code') is-invalid @enderror"
                                               placeholder="{{__('postal_code')}}"
                                               value="{{old('postal_code',$customer->postal_code??null)}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group">
                                        <label for="mobile">
                                            {{__('Mobile')}}
                                        </label>
                                        <input name="mobile" readonly type="text"
                                               class="form-control @error('mobile') is-invalid @enderror"
                                               placeholder="{{__('Mobile')}}"
                                               value="{{old('mobile',$customer->mobile??null)}}"
                                               min-length="10"/>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <div class="form-group">
                                        <label for="description">
                                            {{__('Description')}}/{{__("Page name")}}/{{__("Store")}}
                                        </label>
                                        <input name="description" type="text"
                                               class="form-control @error('description') is-invalid @enderror"
                                               placeholder="{{__('Description')}}"
                                               value="{{old('description',$customer->description??null)}}"
                                        />
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="form-group">
                                        <label for="password">
                                            {{__('Password')}}
                                        </label>
                                        <input name="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="{{__('Password')}}" value="{{old('password',''??null)}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3 mt-3">
                                    <div class="form-group">
                                        <label for="password_confirmation">
                                            {{__('password repeat')}}
                                        </label>
                                        <input name="password_confirmation" type="password"
                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                               placeholder="{{__('password repeat')}}"
                                               value="{{old('password_confirmation',$customer->password_confirmation??null)}}"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="state"
                                               class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>
                                        <select id="state" data-val="{{old('state',$customer->state??null)}}"
                                                type="text"
                                                class="form-control @error('state') is-invalid @enderror" name="state"
                                                required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="city"
                                               class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                                        <select id="city" data-val="{{old('city',$customer->city??null)}}" type="text"
                                                class="form-control @error('city') is-invalid @enderror" name="city"
                                                required>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group">
                                        <label for="password">
                                            {{__('Address')}}
                                        </label>
                                        <textarea name="address" type="password"
                                                  class="form-control @error('address') is-invalid @enderror"
                                                  placeholder="{{__('Address')}}">{{old('address',$customer->address??null)}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label> &nbsp;</label>
                                    <input type="submit" class="btn btn-primary mt-2" value="{{__('Save')}}"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="invoices" class="profile-tab">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__("Products")}}</th>
                                <th>{{__("Total Price")}}</th>
                                <th>{{__("Status")}}</th>
                                <th>{{__("Ref ID")}}</th>
                                <th>{{__("Created At")}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Models\Invoice::whereCustomerId(auth('customer')->id())->with('successPayments')->get() as $invoice)
                                <tr class="{{$invoice->status===\App\Models\Invoice::COMPLETED?'text-success':''}}">
                                    <td>{{$loop->index+1}}</td>
                                    <td style="width: 45%">
                                        {{$invoice->products->implode('name','، ')}}
                                        @if($invoice->invoice != null)
                                            [
                                            <a href="{{route('customer.invoice',$invoice->invoice->hash)}}">
                                                {{__("Belong to")}}
                                            </a>
                                            ]
                                        @endif
                                    </td>
                                    <td>
                                        {{number_format($invoice->total_price)}}
                                        {{config('app.currency_type')}}
                                    </td>
                                    <td>{{__($invoice->status)}}
                                        - {{$invoice->successPayments->implode('type')}}</td>
                                    <td>{{($invoice->successPayments->first()->reference_id??'-')}}</td>
                                    <td>{{$invoice->created_at->diffForHumans()}}</td>
                                    <td>
                                        @if($invoice->status===\App\Models\Invoice::PENDING || $invoice->status===\App\Models\Invoice::FAILED)

                                            <a href="{{route('redirect.bank',['invoice'=>$invoice->hash,'gateway'=>config('app.pay_gate')])}}"
                                               class="btn btn-success ">
                                                <i class="far fa-credit-card"></i>
                                            </a>
                                        @else
                                        @endif
                                        <a href="{{route('customer.invoice',$invoice->hash)}}" class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="crt" class="profile-tab">
                        <div class="p3">
                            <h3 class="p3 pt-4 text-center">
                                {{__("Credit")}}
                            </h3>
                            <hr>
                            <h4 class="p-3 text-center">
                                {{__("Your credit")}}:
                                {{number_format(auth('customer')->user()->credit)}}
                                {{config('app.currency_type')}}
                            </h4>
                            <hr>
                            <h5 class="p-3">
                                تاریخچه استفاده اعتبار
                            </h5>
                            <ul class="list-group m-2">
                                @foreach(auth('customer')->user()->credits  as $c)
                                    <li class="list-group-item">
                                        <div class="row text-center">
                                            <div class="col-md">


                                                مبلغ
                                                {{number_format($c->amount)}}
                                                {{config('app.currency_type')}}
                                            </div>
                                            <div class="col-md">
                                                <a href="{{route('customer.invoice',$c->invoice->hash)}}">
                                                    {{__("Invoice")}}
                                                </a>
                                            </div>
                                            <div class="col-md">
                                                {{__("Pay by credit")}}:
                                                {{number_format($c->invoice->credit_price)}}
                                                {{config('app.currency_type')}}
                                            </div>
                                            <div class="col-md">
                                                {{__("Price")}}
                                                {{number_format($c->invoice->total_price)}}
                                                {{config('app.currency_type')}}
                                            </div>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div id="tickets" class="profile-tab">
                        <div class="p3">
                            <table class="table table-bordered table-hover table-striped ">
                                <tr>
                                    <th>
                                        {{__("Title")}}
                                    </th>
                                    <th>
                                        {{__("Status")}}
                                    </th>
                                    <th>
                                        {{__("Last update")}}
                                    </th>
                                    <th>
                                        -
                                    </th>
                                </tr>
                                @foreach(auth('customer')->user()->main_tickets as $ticket)
                                    <tr>
                                        <td>
                                            {{$ticket->title}}
                                        </td>
                                        <td>
                                            {{__($ticket->status)}}
                                        </td>
                                        <td>{{$ticket->updated_at->diffForHumans()}}</td>
                                        <td>
                                            <a href="{{route('ticket.show',$ticket->id)}}" class="btn btn-secondary">
                                                {{__("Show")}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div id="new" class="profile-tab">
                        <form class="row p-3" method="post" action="{{route('ticket.send')}}">
                            @csrf
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">
                                        {{__("Title")}}
                                    </label>
                                    <input type="text" id="title" name="title" value="{{old('title')}}"
                                           placeholder="{{__("Title")}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="body">
                                        {{__("Text")}}
                                    </label>
                                    <textarea name="body" id="body" class="form-control"
                                              placeholder="{{__("Your question or request...")}}"
                                              rows="5">{{old('body')}}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100">
                                    {{__("Send")}}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="req" class="profile-tab">
                        <form class="row p-3" method="post" action="{{route('ticket.send')}}">
                            @csrf
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">
                                        متن درخواست خود را به همراه توضیحات در مورد فروشگاه بنویسید
                                    </label>
                                    <input type="hidden" id="title" name="title" value="{{__("Application request")}}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="body">
                                        {{__("Text")}}
                                    </label>
                                    <textarea name="body" id="body" class="form-control"
                                              placeholder="{{__("Application request")}}"
                                              rows="5">{{old('body')}}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100">
                                    {{__("Send")}}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="favs" class="profile-tab">
                        <div class="row">

                            @foreach(auth('customer')->user()->products as $p)
                                <div class="col-md-3">
                                    @include('website.component.pro',['p' => $p])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="address" class="profile-tab">
                        <div class="p-4">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <b>
                                        {{__("Main address")}}:
                                    </b>
                                    {{auth('customer')->user()->address}}
                                </li>
                                @foreach(auth('customer')->user()->addresses as $ad)
                                    <li class="list-group-item">
                                        {{$ad->address}}
                                        <a href="{{route('customer.remaddress',$ad->id)}}" class="btn btn-danger delete-confirm float-end">
                                            <span class="fa fa-times"></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <hr>
                            <h5>
                                {{__("Add address")}}
                            </h5>
                            <form action="{{route('customer.address')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state_"
                                                   class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>
                                            <select id="state_" data-val="{{old('state',$customer->state??null)}}"
                                                    type="text"
                                                    class="form-control @error('state') is-invalid @enderror" name="state"
                                                    required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city_"
                                                   class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                                            <select id="city_" data-val="{{old('city',$customer->city??null)}}" type="text"
                                                    class="form-control @error('city') is-invalid @enderror" name="city"
                                                    required>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="form-group">
                                            <label for="password">
                                                {{__('Address')}}
                                            </label>
                                            <textarea name="address" type="password"
                                                      class="form-control @error('address') is-invalid @enderror"
                                                      placeholder="{{__('Address')}}">{{old('address')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="cold-12">
                                        <button class="btn btn-primary w-100">
                                            {{__("Add address")}}
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
