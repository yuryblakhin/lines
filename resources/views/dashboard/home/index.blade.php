@extends('layouts.dashboard')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header"><h3 class="card-title">{{ __('Dashboard') }}</h3></div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                {{ __('You are logged in!') }}
            </div>
        </div>
    </div>
@endsection
