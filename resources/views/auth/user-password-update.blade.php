@extends('layouts.auth')

@php
$pageTitle[] = 'Alterar Senha';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('user-password.update') }}" class="space-y-4" autocomplete="off">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="current_password">
                Senha Atual
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="password"
                name="current_password" required>
            @include('utils.error', ['input' => 'current_password'])
        </div>

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
                Alterar Senha
            </x-primary-button>
        </div>
    </form>
@endsection
