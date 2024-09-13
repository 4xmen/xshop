@extends('layouts.raw')
@section('title')
    {{ __('Login') }} |
@endsection
@section('content')

    <div class="forms">
        @if(config('app.demo'))
            <div class="alert alert-warning mb-5">
                {{__("DEMO VERSION")}}
                <hr>
                {{__("Default admin email is :E1 (developer) or :E2 (admin) and default password is: :P",["E1" => '`developer@example.com`','E2' => '`admin@example.com`','P' => '`password`' ])}}
            </div>
        @endif

        <div class="card" id="raw-form">
            <div class="card-header">
                {{__("Login")}}
            </div>
            <img src="{{asset('panel/images/xshop-logo.svg')}}" class="xshop-raw-logo" alt="logo">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="row mb-3 mt-3">
                        {{--                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>--}}

                        <div class="col-md-12">
                            <div class="input-group mb-2">
                            <span class="input-group-text" id="basic-mail">
                                <i class="ri-mail-line"></i>
                            </span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       autofocus placeholder="{{ __('Email Address') }}">

                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        {{--                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>--}}

                        <div class="col-md-12">
                            <div class="input-group">

                            <span class="input-group-text" id="basic-password">
                                <i class="ri-lock-password-line"></i>
                            </span>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required
                                       autocomplete="current-password" placeholder="{{ __('Password') }}">

                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input"
                                       {{ old('remember',true) ? 'checked' : '' }} name="remember"
                                       type="checkbox" role="switch" id="remember" aria-label="Username"
                                       aria-describedby="basic-addon1">
                                <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-0">
                        <button type="submit" class="circle-btn">
                            {{ __('Login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
