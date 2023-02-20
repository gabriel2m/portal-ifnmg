@extends('layouts.main')

@prepend('styles')
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <style>
        .font-sans {
            font-family: Nunito, sans-serif;
        }
    </style>
@endprepend

@section('content')
    <main class="my-auto antialiased font-sans app-row md:ml-48">
        <strong class="text-gray-500 text-2xl md:text-3xl">
            {{ __('Error') }}
        </strong>

        <div class="text-gray-800 text-5xl md:text-[9rem] font-black my-4">
            @yield('code', __('Oh no'))
        </div>

        <div class="w-16 h-1 bg-purple-500 my-3 md:my-6"></div>

        <p class="text-gray-600 text-2xl md:text-3xl font-light mb-8 leading-normal">
            @yield('message')
        </p>

        <a href="{{ url()->previous() }}">
            <button
                class="text-gray-500 font-bold uppercase tracking-wide py-2 px-6 border-2 border-gray-300 hover:border-gray-400 rounded-xl">
                {{ '<- ' . __('Voltar') }}
            </button>
        </a>
    </main>
@endsection
