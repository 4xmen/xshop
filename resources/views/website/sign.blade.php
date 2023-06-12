@extends('website.layout.layout')
@section('title')
    {{__("Signup or Login")}} -
@endsection
@section('body-class') pink-pattern @endsection
@section('content')
    <div id="main-conetent">
        <section id="customer" class="wow zoomInUp" data-wow-delay=".5">

            @include('starter-kit::component.err')
            <div class="container pt-4 pb-4">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                ورود
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <form method="POST" action="{{ route('signin') }}" class="">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email"
                                               class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email"
                                                   value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password"
                                               class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                       id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Login') }}
                                            </button>

                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                ثبت نام
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div id="sign-form">
                                    <div class="ribbon" data-text="{{__("Login")}}">
                                        {{__("Register")}}
                                    </div>
                                    <div class="">
                                        <div class="col-md-9 m-auto">

                                            <form method="POST" action="{{ route('signup') }}" class="frm pt-4">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="name"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Full name') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="name" type="text"
                                                               class="form-control @error('name') is-invalid @enderror"
                                                               name="name"
                                                               value="{{ old('name') }}" required autocomplete="name"
                                                               autofocus>

                                                        @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="email"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="email" type="email"
                                                               class="form-control @error('email') is-invalid @enderror"
                                                               name="email"
                                                               value="{{ old('email') }}" required autocomplete="email">

                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="mobile"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Mobile') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="mobile" type="text"
                                                               class="form-control @error('mobile') is-invalid @enderror"
                                                               name="mobile"
                                                               value="{{ old('mobile') }}" required
                                                               autocomplete="mobile" autofocus>

                                                        @error('mobile')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="password-confirm"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="password-confirm" type="password"
                                                               class="form-control"
                                                               name="password_confirmation" required
                                                               autocomplete="new-password">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="password"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="password" type="password"
                                                               class="form-control @error('password') is-invalid @enderror"
                                                               name="password" required autocomplete="new-password">

                                                        @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="state"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('State') }}</label>

                                                    <div class="col-md-6">
                                                        <select id="state" type="text"
                                                                class="form-control @error('state') is-invalid @enderror"
                                                                name="state" data-val="8" required>
                                                        </select>
                                                        @error('state')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="city"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>

                                                    <div class="col-md-6">
                                                        <select id="city" type="text"
                                                                class="form-control @error('city') is-invalid @enderror"
                                                                name="city" required>
                                                        </select>
                                                        @error('city')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label for="postal_code"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Postal code') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="postal_code" type="text"
                                                               class="form-control @error('postal_code') is-invalid @enderror"
                                                               name="postal_code"
                                                               value="{{ old('postal_code') }}" required
                                                               autocomplete="postal_code" autofocus>

                                                        @error('postal_code')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="address"
                                                           class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                                                    <div class="col-md-6">
                                        <textarea id="address" type="text"
                                                  class="form-control @error('address') is-invalid @enderror" rows="3"
                                                  name="address" required>{{ old('address') }}</textarea>

                                                        @error('address')
                                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Register') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
