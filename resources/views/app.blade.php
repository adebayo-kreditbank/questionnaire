<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('v1/img/logo/favicon.png') }}" rel="icon">

    <!-- Links -->
    <link href="{{ asset('v1/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('v1/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('v1/css/manual.min.css') }}" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body>
    <noscript>
        <strong>We're sorry but this app doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>

    <div id="app">
        <app />
    </div>

    @vite('resources/js/app.js')

    <script src="{{ asset('v1/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('v1/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('v1/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('v1/js/manual.min.js') }}"></script>
    <script src="{{ asset('v1/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('v1/js/demo/chart-area-demo.js') }}"></script>
</body>
</html>