@extends('layouts.admin')

@php
$title = $material->exists ? [$material->nome, 'Editar Material'] : ['Adicionar Material'];
@endphp

@section('main-content')
    @include('admin.utils.content-title', [
        'text' => $material->exists ? $title[1] : null,
    ])
    <div class="mx-auto max-w-screen-lg">
        <form method="POST" action="{{ $material->exists ? route('admin.materiais.update', $material) : route('admin.materiais.store') }}"
            class="form-primary" autocomplete="off">
            @csrf
            @if ($material->exists)
                @method('PUT')
            @endif
            <div>
                <label class="label-primary" for="nome">
                    Nome
                </label>
                <input type="text" name="nome" class="input-primary" value="{{ old('nome', $material->nome) }}" required>
                @include('utils.error', ['input' => 'nome'])
            </div>
            <div>
                <label class="label-primary" for="catmat">
                    CATMAT
                </label>
                <input type="number" name="catmat" class="input-primary" value="{{ old('catmat', $material->catmat) }}"
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
                        <option value="{{ $unidade_id }}" @selected(old('unidade_id', $material->unidade_id) == $unidade_id)>
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
                <textarea name="descricao" class="input-primary" rows="5" required>{{ old('descricao', $material->descricao) }}</textarea>
                @include('utils.error', ['input' => 'descricao'])
            </div>
            @include('admin.utils.form-footer')
        </form>
    </div>
@endsection
