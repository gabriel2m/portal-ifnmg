<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $pageTitle[] = config('app.name');
    @endphp
    <title>{{ implode(' | ', $pageTitle) }}</title>
    @include('layouts._icomoon-font-face')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('head')
</head>

<body class="flex flex-col min-h-screen bg-gray-50 text-slate-800">
    @yield('header')

    @yield('main')

    @yield('footer')

    <script src="{{ mix('js/app.js') }}"></script>
    @yield('extra-js')
</body>

</html>
