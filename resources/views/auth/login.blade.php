@extends('layouts.auth')

@php
$title[] = 'Login';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('login') }}" class="form-primary" autocomplete="off">
        @csrf

        <div>
            <label class="label-primary" for="name">
                Usuário
            </label>
            <input class="input-primary" type="text" name="name" value="{{ old('name') }}" required autofocus>
            @include('utils.error', ['input' => 'name'])
        </div>

        <div>
            <label class="label-primary" for="password">
                Senha
            </label>
            <input class="input-primary" type="password" name="password" required>
            @include('utils.error', ['input' => 'password'])
        </div>

        <div>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="text-gray-600" @if (old('remember')) checked @endif>
                Lembrar
            </label>
        </div>

        <div class="form-footer-primary">
            <button type="submit" class="button-primary">
                Login
            </button>
            <a href="{{ route('password.request') }}" class="text-blue-600 underline hover:text-gray-500">
                Esqueceu sua senha?
            </a>
        </div>
    </form>
@endsection
