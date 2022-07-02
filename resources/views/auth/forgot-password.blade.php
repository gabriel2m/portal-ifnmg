@extends('layouts.auth')

@php
$pageTitle[] = 'Redefinir Senha';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
        @csrf

        <div>
            <label class="label-primary" for="email">
                Email
            </label>
            <input class="input-primary" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @include('utils.error', ['input' => 'email'])
        </div>

        <div class="form-footer-primary">
            <button type="submit" class="button-primary">
                Enviar Link
            </button>
        </div>
    </form>
@endsection
