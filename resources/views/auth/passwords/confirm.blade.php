@extends('auth.layouts.app')

@section('auth')
    <div class="login-box">
        <div class="login-logo">
            <a href="/">{{ config('app.name', 'Laravel') }}</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('Please confirm your password before continuing.') }}</p>

                <form action="{{ route('password.confirm') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" autocomplete="current-password">

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                {{ __('Confirm Password') }}
                            </button>
                        </div>
                    </div>
                </form>

                @if (Route::has('password.request'))
                    <div class="mt-3">
                        <a class="btn btn-link p-0" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </div>
                @endif

                <p class="mt-2 mb-1">
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection
