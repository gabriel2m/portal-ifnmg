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
    
    $has_admin_permission = auth()
        ->user()
        ->hasPermission(UserPermission::Admin);
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
                    <select id="material_unidade_id" name="material_unidade_id" class="form-control" required
                        @disabled(!$has_admin_permission && $material_compra->exists)>
                        <option></option>
                        @foreach ($materiais_unidades as $item)
                            <option value="{{ $item->id }}" @selected($item->id == $material_compra->material_unidade_id)>
                                {{ $item->material->catmat }} - {{ $item->material->nome }} - {{ $item->unidade->nome }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error input='material_unidade_id' />
                </div>

                <div class="pt-3 pb-2 mt-4 mb-3 border-top border-bottom">
                    <label>
                        Valor unitário
                    </label>
                    <x-input-error input="valores" />
                    <div class="row">
                        @foreach (range(0, 4) as $item)
                            <div class="col-sm-6 col-md-4 col-lg">
                                <div class="form-group">
                                    <label>
                                        #{{ $loop->iteration }}
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                R$
                                            </span>
                                        </div>
                                        <input type="text" name="valores[{{ $item }}][valor]"
                                            class="form-control reais"
                                            value="{{ old("valores.$item.valor", $material_compra->valores[$item]->valor ?? null) }}">
                                    </div>
                                    <x-input-error input="valores.{{ $item }}.valor" />
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($has_admin_permission)
                        <div class="form-group">
                            <label>
                                Responsável pela cotação
                            </label>
                            <input type="text" name="responsavel_valores" class="form-control"
                                value="{{ $material_compra->responsavel_valores }}">
                            <x-input-error input="responsavel_valores" />
                        </div>
                    @endif
                </div>

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
                            <div data-repeater-list="quantidades">
                                @php
                                    $quantidades = old(
                                        'quantidades',
                                        $material_compra->quantidades?->count()
                                            ? $material_compra->quantidades
                                            : [
                                                [
                                                    'setor_id' => null,
                                                    'quantidade' => null,
                                                ],
                                            ],
                                    );
                                @endphp
                                @foreach ($quantidades as $index => $quantidade)
                                    <div data-repeater-item>
                                        <div class="row">
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <select class="custom-select"
                                                                name="[{{ $index }}][setor_id]">
                                                                <option></option>
                                                                @foreach ($setores as $setor_id => $setor_nome)
                                                                    <option value="{{ $setor_id }}"
                                                                        @selected($setor_id == $quantidade['setor_id'])>
                                                                        {{ $setor_nome }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <x-input-error input='{{ "quantidades.$index.setor_id" }}' />
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <input type="text" name="[{{ $index }}][quantidade]"
                                                                class="form-control quantidade"
                                                                value="{{ $quantidade['quantidade'] }}">
                                                            <x-input-error input='{{ "quantidades.$index.quantidade" }}' />
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

                        <x-input-error input='quantidades' />
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

        $('.reais').inputmask("currency", {
            onBeforeMask: val => val.replace('.', ','),
            showMaskOnHover: false,
            radixPoint: ",",
            groupSeparator: ".",
            rightAlign: false,
            unmaskAsNumber: true,
            removeMaskOnSubmit: true
        });

        $('.reais').focusout(event => {
            if ($(event.target).val() == '0,00') {
                $(event.target).val('');
            }
        });

        $('.quantidade').inputmask('integer', {
            rightAlign: false,
            showMaskOnHover: false,
        });

        $('.repeater').repeater({
            initEmpty: @js(!count(old('quantidades', $material_compra->quantidades?->count() ? $material_compra->quantidades : []))),
            show: function() {
                $(this).slideDown();

                $('.quantidade').inputmask('integer', {
                    rightAlign: false,
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        })
    </script>
@endprepend
