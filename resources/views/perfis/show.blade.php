@extends('layouts.main')

@php
    $title[] = $perfil->nome;
@endphp

@section('main-content')
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
        @if (auth()->user()
                ?->hasPermission(UserPermission::Editor))
            <div class="form-footer-primary mt-12">
                <a href="{{ route('perfis.edit', $perfil) }}" class="button-primary">
                    Editar
                </a>
                <form action="{{ route('perfis.destroy', $perfil) }}" method="POST"
                    onsubmit="return confirm('Desja realmente deletar esse perfil?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-gray-400 underline">Deletar</button>
                </form>
            </div>
        @else
            <div class="my-20"></div>
        @endif
    </div>
@endsection
