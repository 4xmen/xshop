@extends('website.layout')
@section('title')
    {{__("Signup or Login")}} -
@endsection
@section('body-class') pink-pattern @endsection
@section('content')
    <div id="main-conetent" class="container">
        <section id="customer" class="wow zoomInUp" data-wow-delay=".5">

            @include('starter-kit::component.err')
            <div class="card mt-5 mb-5 m-auto" style="max-width: 20rem;">
                <div class="card-body">
                    <img src="{{asset('images/logo.png')}}" class="img-fluid" alt="logo">
                    <hr>
                    <h5 class="card-title text-center">
                        {{__("Login / Register")}}
                    </h5>
                    <div id="sign-sms">
                        <div class="form-group">
                            <label for="mobile" class="mb-2">
                                {{__("Mobile")}}
                            </label>
                            <input type="tel" id="mobile" name="mobile" value="" placeholder="{{__("Mobile")}}"
                                   class="form-control">
                        </div>
                        <div id="sms-code">

                            <div class="mb-2 text-center">
                                {{__("SMS Code")}}
                            </div>
                            <div class="row" style="direction: ltr">
                                <div class="col">
                                    <input type="text" id="sms-first" class="form-control sms-pass" name="pass[]" maxlength="1">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control sms-pass" name="pass[]" maxlength="1">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control sms-pass" name="pass[]" maxlength="1">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control sms-pass" name="pass[]" maxlength="1">
                                </div>
                                <div class="col">
                                    <input type="text" id="sms-last" class="form-control sms-pass" name="pass[]" maxlength="1">
                                </div>
                            </div>
                        </div>
                        <button id="sms-btn" data-customer="{{route('customer')}}" data-check="{{route('checkSMS')}}" data-send="{{route('sendSMS')}}" class="btn btn-primary w-100 mb-2 mt-3">
                            {{__("Try login")}}
                        </button>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
