@extends('layouts.main')

@php
$pageTitle[] = 'Entre em Contato';
$showBanner = false;
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.content-title')
        <form method="POST" action="{{ route('contato.send') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="nome">
                    Seu Nome
                </label>
                <input type="text" name="nome" class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3"
                    value="{{ old('nome') }}" required>
                @include('utils.error', ['input' => 'nome'])
            </div>
            <div>
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email">
                    Seu Email
                </label>
                <input type="email" name="email"
                    class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3"
                    value="{{ old('email') }}" required val>
                @include('utils.error', ['input' => 'email'])
            </div>
            <div>
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="assunto">
                    Assunto
                </label>
                <input type="text" name="assunto"
                    class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3"
                    value="{{ old('assunto') }}" required>
                @include('utils.error', ['input' => 'assunto'])
            </div>
            <div>
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email">
                    Mensagem
                </label>
                <textarea name="mensagem" rows="10" class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3"
                    required>{{ old('mensagem') }}</textarea>
                @include('utils.error', ['input' => 'mensagem'])
            </div>
            <div class="pt-5 px-3 border-t border-gray-200">
                <x-primary-button>
                    Enviar
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
