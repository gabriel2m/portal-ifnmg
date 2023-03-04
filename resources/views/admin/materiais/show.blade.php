@extends('admin.materiais.base')

@php
    $title[] = $material->nome;
    $breadcrumb = [
        [
            'link' => route('admin.materiais.index'),
            'label' => 'Materiais',
        ],
        [
            'label' => $material->nome,
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
                            {{ $material->catmat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Nome
                        </th>
                        <td>
                            {{ $material->nome }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Tipo
                        </th>
                        <td>
                            {{ $material->tipo->label() }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Descrição
                        </th>
                        <td>
                            {{ $material->descricao }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Unidade de medida
                        </th>
                        <td>
                            {{ $material->unidade->nome }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.materiais.edit', $material) }}" class="btn btn-primary">
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
                            <form action="{{ route('admin.materiais.destroy', $material) }}" method="post">
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
