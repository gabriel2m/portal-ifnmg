@extends('layouts.auth')

@php
$title[] = 'Redefinir Senha';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('password.update') }}" class="form-primary" autocomplete="off">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <input type="hidden" name="email" value="{{ $request->email }}">

        <div>
            <label class="label-primary" for="password">
                Nova Senha
            </label>
            <input class="input-primary" type="password" name="password" required>
            @include('utils.error', ['input' => 'password'])
        </div>

        <div>
            <label class="label-primary" for="password_confirmation">
                Confirmar
            </label>
            <input class="input-primary" type="password" name="password_confirmation" required>
            @include('utils.error', ['input' => 'password_confirmation'])
        </div>

        <div class="form-footer-primary">
            <button type="submit" class="button-primary">
                Redefinir Senha
            </button>
        </div>
    </form>
@endsection
