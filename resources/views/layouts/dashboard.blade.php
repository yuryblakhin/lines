<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" href="{{ mix('/assets/css/app.css') }}" />
        <script src="{{ mix('/assets/js/app.js') }}"></script>
    </head>
    <body>
    <div class="page">
        @include('layouts.partials.sidebar')
        <div class="page-wrapper">
            <div class="page-header d-print-none">
                <div class="container-xl">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <div class="page-pretitle">{{ $description }}</div>
                            <h2 class="page-title">{{ $title }}</h2>
                        </div>
                        <div class="col-auto ms-auto d-print-none">
                            @yield('actionButtons')
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-deck row-cards">
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('layouts.partials.footer')
        </div>
    </div>
    @yield('scripts')
    </body>
</html>
