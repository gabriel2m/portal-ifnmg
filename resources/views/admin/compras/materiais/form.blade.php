@extends('admin.compras.materiais.base')

@php
    $breadcrumb = [
        [
            'link' => route('admin.compras.index'),
            'label' => 'Compras',
        ],
        [
            'link' => route('admin.compras.show', $material_compra->compra),
            'label' => $material_compra->compra->ano,
        ],
        [
            'link' => route('admin.compras.show', $material_compra->compra),
            'label' => 'Materiais',
        ],
    ];
    if ($material_compra->exists) {
        $title = ['Editar', $material->nome];
        array_push(
            $breadcrumb,
            [
                'label' => $material->nome,
                'link' => route('admin.compras.materiais.show', [
                    'compra' => $material_compra->compra->ano,
                    'material' => $material->catmat,
                ]),
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

@push('styles')
    <link rel="stylesheet" href="{{ mix('select2/select2.full.min.css') }}">
    <style>
        #quantidades-table thead th {
            border-top: 0;
        }

        #quantidades-table th {
            white-space: nowrap;
        }

        #quantidades-table td {
            width: 100%;
        }
    </style>
@endpush

@section('content')
    <form method="POST"
        action="{{ $material_compra->exists
            ? route('admin.compras.materiais.update', [
                'compra' => $material_compra->compra->ano,
                'material' => $material->catmat,
            ])
            : route('admin.compras.materiais.store', [
                'compra' => $material_compra->compra->ano,
            ]) }}"
        class="form-primary" autocomplete="off">
        @csrf
        @if ($material_compra->exists)
            @method('PUT')
        @endif
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>
                        Material
                    </label>
                    <select id="material_id" name="material_id" class="form-control" style="width: 100%;">
                        <option></option>
                        @foreach ($materiais as $material_id => $label)
                            <option value="{{ $material_id }}" @selected($material_compra->material_id == $material_id)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error input='material_id' />
                </div>
                <div class="form-group">
                    <label>
                        Valor unitário
                    </label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                R$
                            </span>
                        </div>
                        <input type="text" id="valor" name="valor" class="form-control"
                            value="{{ $material_compra->valor }}" required>
                    </div>
                    <x-input-error input='valor' />
                </div>
                <div class="table-responsive">
                    <x-input-error input='material_compra_setor' />
                    <table id="quantidades-table" class="table w-100">
                        <thead>
                            <tr>
                                <th>
                                    Setor
                                </th>
                                <th>
                                    Quantidade
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($setores as $item)
                                <tr>
                                    <th class="text-muted">
                                        {{ $item->nome }}
                                    </th>
                                    <td>
                                        <input type="hidden" name="material_compra_setor[{{ $item->id }}][setor_id]"
                                            value="{{ $item->id }}">
                                        <input type="text" name="material_compra_setor[{{ $item->id }}][quantidade]"
                                            class="form-control quantidade" value="{{ $quantidades[$item->id] ?? '' }}">
                                        <x-input-error input='{{ "material_compra_setor.$item->id.quantidade" }}' />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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

@prepend('scripts')
    <script src="{{ mix('select2/select2.full.min.js') }}"></script>
    <script src="{{ mix('inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $('#material_id').select2({
            theme: 'bootstrap4'
        });

        $('#valor').inputmask("currency", {
            onBeforeMask: val => val.replace('.', ','),
            "radixPoint": ",",
            "groupSeparator": ".",
            "rightAlign": false,
            "unmaskAsNumber": true,
            "removeMaskOnSubmit": true
        });

        $('.quantidade').inputmask('integer', {
            "rightAlign": false,
        });
    </script>
@endprepend
