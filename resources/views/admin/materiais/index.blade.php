@extends('layouts.admin')

@php
$pageTitle[] = 'Materiais';
@endphp

@section('content')
    @include('admin.utils.content-title')
    <form method="GET" action="" class="form-primary mb-5"> {{-- ALTERAR ACTION --}}
        <div>
            <label class="label-primary" for="nome">
                Nome
            </label>
            <input type="text" name="nome" class="input-primary" value="{{ old('nome', $material_search->nome) }}">
            @include('utils.error', ['input' => 'nome'])
        </div>
        <div>
            <label class="label-primary" for="descricao">
                Descrição
            </label>
            <input type="text" name="descricao" class="input-primary"
                value="{{ old('descricao', $material_search->descricao) }}">
            @include('utils.error', ['input' => 'descricao'])
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="label-primary" for="catmat">
                    CATMAT
                </label>
                <input type="number" name="catmat" class="input-primary h-3/5"
                    value="{{ old('catmat', $material_search->catmat) }}">
                @include('utils.error', ['input' => 'catmat'])
            </div>
            <div>
                <label class="label-primary" for="unidade_id">
                    Unidade
                </label>
                <select name="unidade_id" class="input-primary h-3/5">
                    <option></option>
                    @foreach ($unidades as $unidade_id => $unidade)
                        <option value="{{ $unidade_id }}" @selected(old('unidade_id', $material_search->unidade_id) == $unidade_id)>
                            {{ $unidade }}
                        </option>
                    @endforeach
                </select>
                @include('utils.error', ['input' => 'unidade_id'])
            </div>
        </div>
        <div class="form-footer-primary">
            <button type="submit"
                class="bg-blue-500 text-white hover:bg-opacity-40 border py-1 px-5 rounded">
                Filtrar
            </button>
        </div>
    </form>
    @include('admin.utils.resource-table', [
        'resource_name' => 'admin.materiais',
        'models' => $materiais,
        'attrs' => [
            'nome' => 'Nome',
            'catmat' => 'CATMAT',
            'descricao' => 'Descrição',
            'unidade_label' => 'Unidade',
        ],
    ])
@endsection
