@extends('layouts.auth')

@php
$title[] = 'Editar Usuário';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('user-profile-information.update') }}" class="form-primary" autocomplete="off">
        @csrf
        @method('PUT')
        <div>
            <label class="label-primary" for="name">
                Usuário
            </label>
            <input class="input-primary" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                autofocus>
            @include('utils.error', ['input' => 'name'])
        </div>
        <div>
            <label class="label-primary" for="email">
                Email
            </label>
            <input class="input-primary" type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                required>
            @include('utils.error', ['input' => 'email'])
        </div>
        <div class="form-footer-primary">
            <button type="submit" class="button-primary">
                Salvar
            </button>
            <a href="{{ route('user-password.update') }}" class="text-blue-600 underline hover:text-gray-500">
                Alterar Senha
            </a>
        </div>
    </form>
@endsection
