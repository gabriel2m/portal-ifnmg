@extends('layouts.auth')

@php
$title[] = 'Alterar Senha';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('user-password.update') }}" class="form-primary" autocomplete="off">
        @csrf
        @method('PUT')

        <div>
            <label class="label-primary" for="current_password">
                Senha Atual
            </label>
            <input class="input-primary" type="password" name="current_password" required>
            @include('utils.error', ['input' => 'current_password'])
        </div>

        <div>
            <label class="label-primary" for="password">
                Nova Senha
            </label>
            <input class="input-primary" type="password" name="password" required>
            @include('utils.error', ['input' => 'password'])
        </div>

        <div>
            <label class="label-primary" for="password">
                Confirmar
            </label>
            <input class="input-primary" type="password" name="password_confirmation" required>
            @include('utils.error', ['input' => 'password_confirmation'])
        </div>

        <div class="form-footer-primary">
            <button type="submit" class="button-primary">
                Alterar Senha
            </button>
        </div>
    </form>
@endsection
