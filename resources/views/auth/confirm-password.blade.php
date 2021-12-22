@extends('layouts.auth')

@php
$pageTitle[] = 'Senha Necessária';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4" autocomplete="off">
        @csrf

        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="password">
                Senha
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="password"
                name="password" required>
            @include('utils.error', ['input' => 'password'])
        </div>

        <div class="flex justify-between pt-4 px-3 border-t border-gray-200">
            <x-primary-button>
                Confirmar
            </x-primary-button>
        </div>
    </form>
@endsection
