@extends('layouts.main')

@php
$pageTitle[] = $perfil->nome;
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        <div class="overflow-auto">
            <img src="{{ $perfil->imagem_url }}" alt="{{ $perfil->nome }}" class="float-left mr-6 my-2 w-52 h-52">
            <h3 class="text-violet-700">
                {{ $perfil->nome }}
            </h3>
            <span class="text-sm text-gray-500">
                #{{ $perfil->categoria->label() }}
            </span>
            <p class="text-xl mt-6">
                {{ $perfil->descricao }}
            </p>
        </div>
        @auth
            <div class="flex justify-between mt-12 pt-6 px-3 border-t border-gray-200">
                <a href="{{ route('perfis.edit', $perfil) }}">
                    <x-primary-button>
                        Editar
                    </x-primary-button>
                </a>
                <form action="{{ route('perfis.destroy', $perfil) }}" method="POST"
                    onsubmit="return confirm('Desja realmente deletar esse perfil?')">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="text-gray-500 hover:text-gray-700 underline">Deletar</button>
                </form>
            </div>
        @endauth
        @guest
            <div class="my-20"></div>
        @endguest
    </div>
@endsection
