@extends('layouts.auth')

@php
$pageTitle[] = 'Senha Necessária';
@endphp

@section('auth-content')
    <form method="POST" action="{{ route('password.confirm') }}" class="form-primary" autocomplete="off">
        @csrf

        <div>
            <label class="label-primary" for="password">
                Senha
            </label>
            <input class="input-primary" type="password" name="password" required>
            @include('utils.error', ['input' => 'password'])
        </div>

        <div class="form-footer-primary">
            <button type="submit" class="button-primary">
                Confirmar
            </button>
        </div>
    </form>
@endsection
