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
            <table class="show-table text-lg w-100">
                <tbody>
                    @foreach ([
            'catmat' => 'CATMAT',
            'nome' => 'Nome',
            'descricao' => 'Descrição',
            'unidade_label' => 'Unidade',
        ] as $attr => $label)
                        <tr>
                            <td>
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
                <i class="far fa-edit"></i>
                Editar
            </a>
            <button type="button" class="btn btn-danger ml-3" data-toggle="modal" data-target="#delete-modal">
                <i class="far fa-trash-alt"></i>
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
