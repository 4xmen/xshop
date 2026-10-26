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
            <div class="auth-card__brand">
                <img src="{{asset('panel/images/xshop-logo.svg')}}" class="xshop-raw-logo" alt="logo">
            </div>
            <div class="card-header">
                {{__("Login")}}
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="auth-card__field">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <div class="input-group">
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

                    <div class="auth-card__field">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
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

                    <div class="auth-card__options">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   {{ old('remember',true) ? 'checked' : '' }} name="remember"
                                   type="checkbox" role="switch" id="remember" aria-label="Username"
                                   aria-describedby="basic-addon1">
                            <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary auth-card__submit">
                        {{ __('Login') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
