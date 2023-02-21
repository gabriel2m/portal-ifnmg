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
    <style>
        #material-table td:first-child {
            font-weight: 600;
            width: 7rem;
        }

        #material-table tr+tr td {
            border-top: 1px solid #dee2e6;
        }

        #material-table tr:not(:first-child) td {
            padding-top: .5rem;
        }

        #material-table tr:not(:last-child) td {
            padding-bottom: .5rem;
        }
    </style>
@endprepend

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="material-table" class="text-lg w-100">
                <tbody>
                    @foreach ([
            'catmat' => 'CATMAT',
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'unidade_label' => 'Unidade',
        ] as $attr => $label)
                        <tr>
                            <td class="font-bold">
                                {{ $label }}
                            </td>
                            <td>
                                {{ $material->$attr }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.materiais.edit', $material) }}" class="btn btn-primary">
                Editar
            </a>
            <button type="button" class="btn btn-danger ml-3" data-toggle="modal" data-target="#delete-modal">
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
                            Deseja realmente deletar esse material?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Cancelar
                            </button>
                            <form action="{{ route('admin.materiais.destroy', $material) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-3">
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
