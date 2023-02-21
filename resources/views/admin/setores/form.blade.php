@extends('admin.setores.base')

@php
    $breadcrumb = [
        [
            'link' => route('admin.setores.index'),
            'label' => 'Setores',
        ],
    ];
    if ($setor->exists) {
        $title = ['Editar', $setor->nome];
        array_push(
            $breadcrumb,
            [
                'label' => $setor->nome,
                'link' => route('admin.setores.show', $setor),
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
    <form method="POST" action="{{ $setor->exists ? route('admin.setores.update', $setor) : route('admin.setores.store') }}"
        class="form-primary" autocomplete="off">
        @csrf
        @if ($setor->exists)
            @method('PUT')
        @endif
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>
                        Setor
                    </label>
                    <input type="text" name="nome" class="form-control" value="{{ $setor->nome }}">
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
