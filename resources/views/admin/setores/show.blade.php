@extends('admin.setores.base')

@php
    $title[] = $setor->nome;
    $breadcrumb = [
        [
            'link' => route('admin.setores.index'),
            'label' => 'Setores',
        ],
        [
            'label' => $setor->nome,
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
            'nome' => 'Setor',
        ] as $attr => $label)
                        <tr>
                            <td>
                                {{ $label }}
                            </td>
                            <td>
                                {{ $setor->$attr }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.setores.edit', $setor) }}" class="btn btn-primary">
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
                                <i class="far fa-times-circle"></i>
                                Cancelar
                            </button>
                            <form action="{{ route('admin.setores.destroy', $setor) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-3">
                                    <i class="far fa-trash-alt"></i>
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
