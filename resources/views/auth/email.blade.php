@extends('layouts.auth')

@section('content')
    <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{ route('home', [], false) }}" class="navbar-brand navbar-brand-autodark">
                {{ config('app.name') }}
            </a>
        </div>
        <form class="card card-md" method="POST" action="{{ route('password.email', [], false) }}">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <h2 class="card-title text-center">{{ __('Reset Password') }}</h2>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

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
                    <button type="submit" class="btn btn-primary w-100">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
