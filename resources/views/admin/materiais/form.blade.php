@extends('admin.materiais.base')

@php
    $breadcrumb = [
        [
            'link' => route('admin.materiais.index'),
            'label' => 'Materiais',
        ],
    ];
    if ($material->exists) {
        $title = ['Editar', $material->getOriginal('nome')];
        array_push(
            $breadcrumb,
            [
                'label' => $material->getOriginal('nome'),
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

@prepend('styles')
    <link rel="stylesheet" href="{{ mix('select2/select2.full.min.css') }}">
@endprepend

@section('content')
    <form method="POST"
        action="{{ $material->exists ? route('admin.materiais.update', $material->getOriginal('catmat')) : route('admin.materiais.store') }}"
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
                        Tipo
                    </label>
                    <select class="custom-select" name="tipo" required>
                        <option></option>
                        @foreach (TipoMaterial::cases() as $tipo)
                            <option value="{{ $tipo->value }}" @selected($material->tipo?->value == $tipo->value)>
                                {{ $tipo->label() }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error input='tipo' />
                </div>

                <div class="form-group">
                    <label>
                        Descrição
                    </label>
                    <textarea name="descricao" class="form-control" required>{{ $material->descricao }}</textarea>
                    <x-input-error input='descricao' />
                </div>
                <div class="form-group">
                    <label>
                        Unidades de medida
                    </label>
                    @php
                        $material_unidades = collect(old('unidades', $material->material_unidades))
                            ->pluck('unidade_id')
                            ->toArray();
                    @endphp
                    <select id="unidades" name="unidades[][unidade_id]" multiple required>
                        @foreach ($unidades as $unidade_id => $unidade_nome)
                            <option value="{{ $unidade_id }}" @selected(in_array($unidade_id, $material_unidades))>
                                {{ $unidade_nome }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error input='unidades' />
                    <x-input-error input='unidades.*' />
                </div>
            </div>
        </div>

        <div class="d-flex mt-3">
            <div class="ml-auto">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="la-lg las la-times-circle"></i>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-success ml-3">
                    <i class="la-lg las la-save"></i>
                    Salvar
                </button>
            </div>
        </div>
    </form>
@endsection

@prepend('scripts')
    <script src="{{ mix('select2/select2.full.min.js') }}"></script>

    <script>
        $('#unidades').select2({
            language: "pt",
            theme: 'bootstrap4 primary w-100'
        })
    </script>
@endprepend
