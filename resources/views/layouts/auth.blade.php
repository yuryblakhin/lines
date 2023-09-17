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
<body class="d-flex flex-column">
    <div class="page page-center">
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>
