@extends('admin.materiais.base')

@php
    $breadcrumb = [
        [
            'link' => route('admin.materiais.index'),
            'label' => 'Materiais',
        ],
    ];
    if ($material->exists) {
        $title = ['Editar', $material->nome];
        array_push(
            $breadcrumb,
            [
                'label' => $material->nome,
                'link' => route('admin.materiais.show', $material),
            ],
            [
                'label' => 'Editar',
                'active' => true,
            ],
        );
    } else {
        $title = ['Adicionar'];
        array_push($breadcrumb, [
            'label' => 'Adicionar',
            'active' => true,
        ]);
    }
@endphp

@section('content')
    <form method="POST"
        action="{{ $material->exists ? route('admin.materiais.update', $material) : route('admin.materiais.store') }}"
        class="form-primary" autocomplete="off">
        @csrf
        @if ($material->exists)
            @method('PUT')
        @endif
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>
                        CATMAT
                    </label>
                    <input type="text" name="catmat" class="form-control" value="{{ $material->catmat }}" required>
                    <x-input-error input='catmat' />
                </div>
                <div class="form-group">
                    <label>
                        Nome
                    </label>
                    <input type="text" name="nome" class="form-control" value="{{ $material->nome }}" required>
                    <x-input-error input='nome' />
                </div>
                <div class="form-group">
                    <label>
                        Unidade de Medida
                    </label>
                    <select class="custom-select" name="unidade_id" required>
                        <option></option>
                        @foreach ($unidades as $unidade_id => $unidade)
                            <option value="{{ $unidade_id }}" @selected($material->unidade_id == $unidade_id)>
                                {{ $unidade }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error input='unidade_id' />
                </div>
                <div class="form-group">
                    <label>
                        Descrição
                    </label>
                    <textarea name="descricao" class="form-control" required>{{ $material->descricao }}</textarea>
                    <x-input-error input='descricao' />
                </div>
            </div>
        </div>

        <div class="d-flex mt-3">
            <div class="ml-auto">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="far fa-times-circle"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-success ml-3">
                    <i class="far fa-hdd"></i>
                    Salvar
                </button>
            </div>
        </div>
    </form>
@endsection
