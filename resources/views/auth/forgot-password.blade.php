@extends('layouts.auth')

@php
$pageTitle[] = 'Redefinir Senha';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
        @csrf

        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="email">
                Email
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="email" name="email"
                value="{{ old('email') }}" required autofocus>
            @include('utils.error', ['input' => 'email'])
        </div>

        <div class="flex justify-between mt-4 pt-4 px-3 border-t border-gray-200">
            <x-primary-button>
                Enviar Link
            </x-primary-button>
        </div>
    </form>
@endsection
