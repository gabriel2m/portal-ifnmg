<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if ($pageTitle ?? false)
        <title>{{ $pageTitle }} | {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- @include('components.layouts.icomoon-font-face')
    <link rel="stylesheet" href="{{ asset('css/icomoon.css') }}"> --}}
</head>

<body class="flex flex-col min-h-screen bg-indigo-50 text-gray-800">
    <header>
        <nav class="py-10 bg-gray-800 custom-row">

        </nav>
        <div class="py-44 bg-green-600 custom-row">

        </div>
    </header>

    <main class="py-16 custom-row">
        {{ $content }}
    </main>

    <footer class="mt-auto">
        <div class="py-10 bg-green-800 custom-row">

        </div>
        <div class="py-7 bg-green-600 custom-row">

        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
