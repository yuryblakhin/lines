@extends('layouts.auth')

@section('content')
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ route('home', [], false) }}" class="navbar-brand navbar-brand-autodark">
                {{ config('app.name') }}
            </a>
        </div>
        <form class="card card-md" method="POST" action="{{ route('password.update', [], false) }}">
            @csrf
            <div class="card-body">
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3">
                    <h2 class="card-title text-center">{{ __('Reset Password') }}</h2>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
