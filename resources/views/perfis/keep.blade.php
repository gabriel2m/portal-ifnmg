@extends('layouts.main')

@php
$pageTitle = $perfil->exists ? [$perfil->nome, 'Editar'] : ['Novo Perfil'];
$showBanner = false;
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.content-title', ['contentTitle' => $perfil->exists ? 'Editar Perfil' : null])
        <form method="POST" enctype="multipart/form-data"
            action="{{ $perfil->exists ? route('perfis.update', $perfil) : route('perfis.store') }}" class="space-y-5"
            autocomplete="off">
            @csrf
            @if ($perfil->exists)
                @method('PUT')
            @endif
            <div>
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="nome">
                    Nome
                </label>
                <input type="text" name="nome" class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3"
                    value="{{ old('nome', $perfil->nome) }}" required>
                @include('utils.error', ['input' => 'nome'])
            </div>
            <div>
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="imagem">
                    Imagem
                </label>
                <input type="file" name="imagem"
                    class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3">
                @include('utils.error', ['input' => 'imagem'])
            </div>
            <div>
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="categorias">
                    Categoria
                </label>
                <select name="categoria"
                    class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-2 bg-white" required>
                    <option></option>
                    @foreach (Perfil::LABELS_CATEGORIAS as $id => $categoria)
                        <option value="{{ $id }}" @if ($perfil->categoria == $id) selected @endif>{{ $categoria }}</option>
                    @endforeach
                </select>
                @include('utils.error', ['input' => 'categoria'])
            </div>
            <div>
                <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="descricao">
                    Descrição
                </label>
                <textarea name="descricao"
                    class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3 text-sm" rows="10"
                    required>{{ old('descricao', $perfil->descricao) }}</textarea>
                @include('utils.error', ['input' => 'descricao'])
            </div>

            <div class="flex justify-between pt-5 px-3 border-t border-gray-200">
                <x-primary-button>
                    Salvar
                </x-primary-button>
                @if ($perfil->exists)
                    <a href="{{ route('perfis.show', $perfil) }}" class="text-gray-500 hover:text-gray-700 underline">
                        Voltar
                    </a>
                @endif
            </div>
        </form>
    </div>
@endsection
