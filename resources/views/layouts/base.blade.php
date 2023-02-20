<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $title[] = config('app.name');
    @endphp
    <title>{{ implode(' | ', $title) }}</title>
    @include('layouts._icomoon-font-face')
    @stack('styles')
</head>

<body {{ new \Illuminate\View\ComponentAttributeBag($body_attrs ?? []) }}>
    @yield('content')
    @stack('scripts')
</body>

</html>
