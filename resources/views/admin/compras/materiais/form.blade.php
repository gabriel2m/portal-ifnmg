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
        $tipo_label = match ($material_unidade->material->tipo) {
            TipoMaterial::Consumo => 'Consumo',
            TipoMaterial::Permanente => 'Permanentes',
        };
        $title = ['Editar', $material_unidade->unidade->nome, $material_unidade->material->nome, $tipo_label];
        array_push(
            $breadcrumb,
            [
                'link' => route('admin.compras.show', $material_compra->compra),
                'label' => $tipo_label,
            ],
            [
                'label' => $material_unidade->material->nome,
                'link' => route('admin.compras.show', $material_compra->compra),
            ],
            [
                'label' => $material_unidade->unidade->nome,
                'link' => route('admin.compras.materiais.show', [
                    'compra' => $material_compra->compra->ano,
                    'material' => $material_unidade->id,
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
@endpush

@section('content')
    <form method="POST"
        action="{{ $material_compra->exists
            ? route('admin.compras.materiais.update', [
                'compra' => $material_compra->compra->ano,
                'material' => $material_unidade->id,
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
                    <select id="material_unidade_id" name="material_unidade_id" class="form-control" required>
                        <option></option>
                        @foreach ($materiais_unidades as $item)
                            <option value="{{ $item->id }}" @selected($item->id == $material_compra->material_unidade_id)>
                                {{ $item->material->catmat }} - {{ $item->material->nome }} - {{ $item->unidade->nome }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error input='material_unidade_id' />
                </div>

                <x-input-error input='material_compra_setor' />
                <div class="table-responsive-md">
                    <div style="min-width: max-content;">
                        <div class="row">
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <label>
                                            Setor
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label>
                                            Quantidade
                                        </label>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-block btn-danger invisible">
                                            <i class="la-lg las la-trash"></i>
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="repeater">
                            <div data-repeater-list="material_compra_setor">
                                @php
                                    $material_compra_setores = old(
                                        'material_compra_setor',
                                        $material_compra->exists
                                            ? $material_compra->material_compra_setores
                                            : [
                                                [
                                                    'setor_id' => null,
                                                    'quantidade' => null,
                                                ],
                                            ],
                                    );
                                @endphp
                                @foreach ($material_compra_setores as $index => $material_compra_setor)
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <select class="custom-select"
                                                                name="[{{ $index }}][setor_id]" required>
                                                                <option></option>
                                                                @foreach ($setores as $setor_id => $setor_nome)
                                                                    <option value="{{ $setor_id }}"
                                                                        @selected($setor_id == $material_compra_setor['setor_id'])>
                                                                        {{ $setor_nome }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <x-input-error
                                                                input='{{ "material_compra_setor.$index.setor_id" }}' />
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="text" name="[{{ $index }}][quantidade]"
                                                                class="form-control quantidade"
                                                                value="{{ $material_compra_setor['quantidade'] }}"
                                                                required>
                                                            <x-input-error
                                                                input='{{ "material_compra_setor.$index.quantidade" }}' />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <button type="button" class="btn btn-block btn-danger"
                                                    data-repeater-delete>
                                                    <i class="la-lg las la-trash"></i>
                                                    Remover
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-primary ml-auto" data-repeater-create>
                                <i class="la-lg las la-plus"></i>
                                Adicionar
                            </button>
                        </div>
                    </div>
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
    <script src="{{ mix('inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ mix('repeater/jquery.repeater.min.js') }}"></script>

    <script>
        $('#material_unidade_id').select2({
            language: "pt",
            theme: 'bootstrap4 w-100'
        });

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $('.quantidade').inputmask('integer', {
            "rightAlign": false,
        });

        $('.repeater').repeater({
            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        })
    </script>
@endprepend
