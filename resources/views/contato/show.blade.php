@extends('layouts.main')

@php
$pageTitle[] = 'Entre em Contato';
$showBanner = false;
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.content-title')
        <form method="POST" action="{{ route('contato.send') }}" class="form-primary">
            @csrf
            <div>
                <label class="label-primary" for="nome">
                    Seu Nome
                </label>
                <input type="text" name="nome" class="input-primary" value="{{ old('nome') }}" required>
                @include('utils.error', ['input' => 'nome'])
            </div>
            <div>
                <label class="label-primary" for="email">
                    Seu Email
                </label>
                <input type="email" name="email" class="input-primary" value="{{ old('email') }}" required>
                @include('utils.error', ['input' => 'email'])
            </div>
            <div>
                <label class="label-primary" for="assunto">
                    Assunto
                </label>
                <input type="text" name="assunto" class="input-primary" value="{{ old('assunto') }}" required>
                @include('utils.error', ['input' => 'assunto'])
            </div>
            <div>
                <label class="label-primary" for="mensagem">
                    Mensagem
                </label>
                <textarea name="mensagem" rows="10" class="input-primary" required>{{ old('mensagem') }}</textarea>
                @include('utils.error', ['input' => 'mensagem'])
            </div>
            <div class="form-footer-primary">
                <button type="submit" class="button-primary">
                    Enviar
                </button>
            </div>
        </form>
    </div>
@endsection
