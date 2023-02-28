@extends('admin.compras.materiais.base')

@php
    $title[] = $material_compra->material->nome;
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
            'label' => $material_compra->material->nome,
            'active' => true,
        ],
    ];
@endphp

@prepend('styles')
    <style>
        #material-compra-table td:last-child {
            width: 1%;
        }

        #material-compra-table thead th {
            border-top: 0;
            white-space: nowrap;
        }
    </style>
@endprepend

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="material-compra-table" class="table table-hover w-100">
                    <thead>
                        <tr>
                            <th>
                                CATMAT
                                <span class="ml-3 font-weight-normal">
                                    {{ $material_compra->material->catmat }}
                                </span>
                            </th>
                            <th>
                                Material
                                <span class="ml-3 font-weight-normal">
                                    {{ $material_compra->material->nome }}
                                </span>
                            </th>
                            <th>
                                Valor unitário
                                <span class="ml-3 font-weight-normal">
                                    {{ reais($material_compra->valor) }}
                                </span>
                            </th>
                            <th>
                                Tipo
                                <span class="ml-3 font-weight-normal">
                                    {{ $material_compra->material->tipo->label() }}
                                </span>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                Setor
                            </th>
                            <th>
                                Quantidade
                            </th>
                            <th>
                                Valor
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $quantidade_total = 0;
                        @endphp
                        @foreach ($material_compra->setores as $item)
                            <tr>
                                <td class="text-muted">
                                    {{ $item->nome }}
                                </td>
                                <td>
                                    {{ int_br($item->pivot->quantidade) }}
                                </td>
                                <td>
                                    {{ reais($material_compra->valor * $item->pivot->quantidade) }}
                                </td>
                                <td>
                                </td>
                            </tr>
                            @php
                                $quantidade_total += $item->pivot->quantidade;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>
                                Total
                            </th>
                            <td>
                                {{ int_br($quantidade_total) }}
                            </td>
                            <td>
                                {{ reais($material_compra->valor * $quantidade_total) }}
                            </td>
                            <td>
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
                'material' => $material_compra->material->catmat,
            ]) }}"
                class="btn btn-primary">
                <i class="la-lg las la-edit"></i>
                Editar
            </a>
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
                                    'material' => $material_compra->material->catmat,
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
        </div>
    </div>
@endsection

@prepend('scripts')
@endprepend
