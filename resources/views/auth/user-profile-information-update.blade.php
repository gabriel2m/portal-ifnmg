@extends('layouts.auth')

@php
$pageTitle[] = 'Editar Usuário';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('user-profile-information.update') }}" class="space-y-4" autocomplete="off">
        @csrf
        @method('PUT')
        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="name">
                Usuário
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="text" name="name"
                value="{{ old('name', auth()->user()->name) }}" required autofocus>
            @include('utils.error', ['input' => 'name'])
        </div>
        <div>
            <label class="block mb-1 uppercase font-bold text-xs text-gray-700" for="email">
                Email
            </label>
            <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="text" name="email"
                value="{{ old('email', auth()->user()->email) }}" required>
            @include('utils.error', ['input' => 'email'])
        </div>
        <div class="flex justify-between pt-4 px-3 border-t border-gray-200">
            <x-primary-button>
                Salvar
            </x-primary-button>
            <a href="{{ route('user-password.update') }}" class="text-blue-600 underline hover:text-gray-500">
                Alterar Senha
            </a>
        </div>
    </form>
@endsection
