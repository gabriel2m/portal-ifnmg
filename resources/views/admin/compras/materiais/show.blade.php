@extends('admin.compras.materiais.base')

@php
    $tipo_label = match ($material_compra->material_unidade->material->tipo) {
        TipoMaterial::Consumo => 'Consumo',
        TipoMaterial::Permanente => 'Permanentes',
    };
    $title = [$material_compra->material_unidade->unidade->nome, $material_compra->material_unidade->material->nome, $tipo_label];
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
        [
            'link' => route('admin.compras.show', $material_compra->compra),
            'label' => $tipo_label,
        ],
        [
            'label' => $material_compra->material_unidade->material->nome,
            'link' => route('admin.compras.show', $material_compra->compra),
        ],
        [
            'label' => $material_compra->material_unidade->unidade->nome,
            'active' => true,
        ],
    ];
@endphp

@prepend('styles')
@endprepend

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table show-table w-100">
                <tbody>
                    <tr>
                        <th>
                            CATMAT
                        </th>
                        <td>
                            {{ $material_compra->material_unidade->material->catmat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Material
                        </th>
                        <td>
                            {{ $material_compra->material_unidade->material->nome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Unidade de medida
                        </th>
                        <td>
                            {{ $material_compra->material_unidade->unidade->nome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Tipo
                        </th>
                        <td>
                            {{ $material_compra->material_unidade->material->tipo->label() }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card card-secondary mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 w-100">
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
                        @php
                            $quantidade_total = 0;
                        @endphp
                        @foreach ($material_compra->quantidades as $quantidade)
                            <tr>
                                <td class="text-nowrap">
                                    {{ $quantidade->setor->nome }}
                                </td>
                                <td>
                                    {{ int_br($quantidade->quantidade) }}
                                </td>
                            </tr>
                            @php
                                $quantidade_total += $quantidade->quantidade;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-bold">
                                Total
                            </td>
                            <td>
                                {{ int_br($quantidade_total) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.compras.materiais.edit', [
                'compra' => $material_compra->compra->ano,
                'material' => $material_compra->material_unidade_id,
            ]) }}"
                class="btn btn-primary">
                <i class="la-lg las la-edit"></i>
                Editar
            </a>

            @if (auth()->user()->hasPermission(UserPermission::Admin))
                <button type="button" class="btn btn-danger ml-3" data-toggle="modal" data-target="#delete-modal">
                    <i class="la-lg las la-trash"></i>
                    Deletar
                </button>

                <!-- Modal -->
                <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Deseja realmente deletar?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary m-0" data-dismiss="modal">
                                    <i class="la-lg las la-times-circle"></i>
                                    Cancelar
                                </button>
                                <form
                                    action="{{ route('admin.compras.materiais.destroy', [
                                        'compra' => $material_compra->compra->ano,
                                        'material' => $material_compra->material_unidade_id,
                                    ]) }}"
                                    method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger ml-3">
                                        <i class="la-lg las la-trash"></i>
                                        Deletar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@prepend('scripts')
@endprepend
