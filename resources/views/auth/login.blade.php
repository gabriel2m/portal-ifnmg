@extends('layouts.auth')

@php
$pageTitle[] = 'Login';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('login') }}" class="space-y-4" autocomplete="off">
        @csrf

        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="name">
                Usuário
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="text" name="name"
                value="{{ old('name') }}" required autofocus>
            @include('utils.error', ['input' => 'name'])
        </div>

        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="password">
                Senha
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="password"
                name="password" required>
            @include('utils.error', ['input' => 'password'])
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="text-gray-600" @if (old('remember')) checked @endif>
                Lembrar
            </label>
        </div>

        <div class="flex justify-between pt-4 px-3 border-t border-gray-200">
            <x-primary-button>
                Login
            </x-primary-button>
            <a href="{{ route('password.request') }}" class="text-blue-600 underline hover:text-gray-500">
                Esqueceu sua senha?
            </a>
        </div>
    </form>
@endsection
