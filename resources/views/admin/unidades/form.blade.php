@extends('admin.unidades.base')

@php
    $breadcrumb = [
        [
            'link' => route('admin.unidades.index'),
            'label' => 'Unidades de Medida',
        ],
    ];
    if ($unidade->exists) {
        $title = ['Editar', $unidade->nome];
        array_push(
            $breadcrumb,
            [
                'label' => $unidade->nome,
                'link' => route('admin.unidades.show', $unidade),
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
        action="{{ $unidade->exists ? route('admin.unidades.update', $unidade) : route('admin.unidades.store') }}"
        class="form-primary" autocomplete="off">
        @csrf
        @if ($unidade->exists)
            @method('PUT')
        @endif
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>
                        Unidade
                    </label>
                    <input type="text" name="nome" class="form-control" value="{{ $unidade->nome }}" required>
                    <x-input-error input='nome' />
                </div>
            </div>
        </div>

        <div class="d-flex mt-3">
            <div class="ml-auto">
                <button type="submit" class="btn btn-success">
                    <i class="far fa-hdd"></i>
                    Salvar
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary ml-3">
                    <i class="far fa-times-circle"></i>
                    Cancelar
                </a>
            </div>
        </div>
    </form>
@endsection
