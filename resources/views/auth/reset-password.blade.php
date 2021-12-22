@extends('layouts.auth')

@php
$pageTitle[] = 'Redefinir Senha';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('password.update') }}" class="space-y-4" autocomplete="off">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <input type="hidden" name="email" value="{{ $request->email }}">

        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="password">
                Nova Senha
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="password"
                name="password" required>
            @include('utils.error', ['input' => 'password'])
        </div>

        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="password">
                Confirmar
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="password"
                name="password_confirmation" required>
            @include('utils.error', ['input' => 'password_confirmation'])
        </div>

        <div class="flex justify-between pt-4 px-3 border-t border-gray-200">
            <x-primary-button>
                Redefinir Senha
            </x-primary-button>
        </div>
    </form>
@endsection
