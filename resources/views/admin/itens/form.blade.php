@extends('layouts.admin')

@php
$pageTitle = $item->exists ? [$item->nome, 'Editar Item'] : ['Adicionar Item'];
@endphp

@section('content')
    @include('admin.utils.content-title', [
        'text' => $item->exists ? $pageTitle[1] : null,
    ])
    <div class="mx-auto max-w-screen-lg">
        <form method="POST" action="{{ $item->exists ? route('admin.itens.update', $item) : route('admin.itens.store') }}"
            class="form-primary" autocomplete="off">
            @csrf
            @if ($item->exists)
                @method('PUT')
            @endif
            <div>
                <label class="label-primary" for="nome">
                    Nome
                </label>
                <input type="text" name="nome" class="input-primary" value="{{ old('nome', $item->nome) }}" required>
                @include('utils.error', ['input' => 'nome'])
            </div>
            <div>
                <label class="label-primary" for="catmat">
                    CATMAT
                </label>
                <input type="number" name="catmat" class="input-primary" value="{{ old('catmat', $item->catmat) }}"
                    required>
                @include('utils.error', ['input' => 'catmat'])
            </div>
            <div>
                <label class="label-primary" for="unidade_id">
                    Unidade
                </label>
                <select name="unidade_id" class="input-primary" required>
                    <option></option>
                    @foreach ($unidades as $unidade_id => $unidade)
                        <option value="{{ $unidade_id }}" @if (old('unidade_id', $item->unidade_id) == $unidade_id) selected @endif>
                            {{ $unidade }}
                        </option>
                    @endforeach
                </select>
                @include('utils.error', ['input' => 'unidade_id'])
            </div>
            <div>
                <label class="label-primary" for="descricao">
                    Descrição
                </label>
                <textarea name="descricao" class="input-primary" rows="5" required>{{ old('descricao', $item->descricao) }}</textarea>
                @include('utils.error', ['input' => 'descricao'])
            </div>
            @include('admin.utils.form-footer')
        </form>
    </div>
@endsection
