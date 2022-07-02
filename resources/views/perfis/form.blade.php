@extends('layouts.main')

@php
$pageTitle = $perfil->exists ? [$perfil->nome, 'Editar'] : ['Novo Perfil'];
$showBanner = false;
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.content-title', [
            'text' => $perfil->exists ? 'Editar Perfil' : null,
        ])
        <form method="POST" enctype="multipart/form-data"
            action="{{ $perfil->exists ? route('perfis.update', $perfil) : route('perfis.store') }}" class="form-primary"
            autocomplete="off">
            @csrf
            @if ($perfil->exists)
                @method('PUT')
            @endif
            <div>
                <label class="label-primary" for="nome">
                    Nome
                </label>
                <input type="text" name="nome" class="input-primary" value="{{ old('nome', $perfil->nome) }}" required>
                @include('utils.error', ['input' => 'nome'])
            </div>
            <div>
                <label class="label-primary" for="imagem">
                    Imagem
                </label>
                <input type="file" name="imagem" class="input-primary">
                @include('utils.error', ['input' => 'imagem'])
            </div>
            <div>
                <label class="label-primary" for="categoria">
                    Categoria
                </label>
                <select name="categoria" class="input-primary" required>
                    <option></option>
                    @foreach (Categorias::cases() as $categoria)
                        <option value="{{ $categoria->value }}" @if (old('categoria', $perfil->categoria?->value) == $categoria->value) selected @endif>
                            {{ $categoria->label() }}
                        </option>
                    @endforeach
                </select>
                @include('utils.error', ['input' => 'categoria'])
            </div>
            <div>
                <label class="label-primary" for="descricao">
                    Descrição
                </label>
                <textarea name="descricao" class="input-primary" rows="10" required>{{ old('descricao', $perfil->descricao) }}</textarea>
                @include('utils.error', ['input' => 'descricao'])
            </div>

            <div class="form-footer-primary">
                <button type="submit" class="button-primary">
                    Salvar
                </button>
                @if ($perfil->exists)
                    @include('utils.back-link')
                @endif
            </div>
        </form>
    </div>
@endsection
