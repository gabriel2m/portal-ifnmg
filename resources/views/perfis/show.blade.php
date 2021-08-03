@extends('layouts.main')

@php
$pageTitle = $perfil->nome;
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        <h2 class="text-violet-700 text-4xl mb-2">
            {{ $perfil->nome }}
        </h2>
        <span class="italic text-sm text-gray-500">
            {{ $perfil->categorias_label }}
        </span>
        <p class="text-xl mt-6">
            {{ $perfil->descricao }}
        </p>
        <div class="flex justify-between mt-6 pt-6 px-3 border-t border-gray-200">
            <form action="{{ route('perfis.destroy', $perfil) }}" method="POST"
                onsubmit="return confirm('Desja realmente deletar esse perfil?')">
                @csrf
                @method("DELETE")
                <button type="submit" class="text-gray-500 hover:text-gray-700 underline">Deletar</button>
            </form>
            <a href="{{ route('perfis.edit', $perfil) }}">
                <x-primary-button>
                    Editar
                </x-primary-button>
            </a>
        </div>
    </div>
@endsection
