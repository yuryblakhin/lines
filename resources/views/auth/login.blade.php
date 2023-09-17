@extends('layouts.auth')

@section('content')
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ route('dashboard.home.index', [], false) }}" class="navbar-brand navbar-brand-autodark">
                {{ config('app.name') }}
            </a>
        </div>
        <form class="card card-md"  method="POST" action="{{ route('auth.login', [], false) }}">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <h2 class="card-title text-center">{{ $title }}</h2>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-check" for="remember">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="form-check-label">{{ __('Remember Me') }}</span>
                    </label>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('Login') }}
                    </button>

                    <a class="link-primary" href="{{ route('password.index') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
