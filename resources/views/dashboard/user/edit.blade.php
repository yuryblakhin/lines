@extends('layouts.dashboard')

@section('content')
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('dashboard.user.update', ['user' => $user->id], false) }}" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="id" class="form-label">{{ __('ID') }}</label>
                        <span id="id" class="form-control disabled">{{ $user->id }}</span>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ $user->first_name }}" required autocomplete="first_name">

                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ $user->last_name }}" required autocomplete="last_name">

                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="created_at" class="form-label">{{ __('Created At') }}</label>
                        <span id="created_at" class="form-control disabled">{{ $user->created_at }}</span>
                    </div>
                    <div class="mb-3">
                        <label for="created_at" class="form-label">{{ __('Updated At') }}</label>
                        <span id="created_at" class="form-control disabled">{{ $user->updated_at }}</span>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
