@extends('admin.compras.base')

@php
    $title[] = $compra->ano;
    $breadcrumb = [
        [
            'link' => route('admin.compras.index'),
            'label' => 'Compras',
        ],
        [
            'label' => $compra->ano,
            'active' => true,
        ],
    ];
@endphp

@prepend('styles')
    <link rel="stylesheet" href="{{ mix('css/datatables.css') }}">
@endprepend

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table show-table w-100">
                <tbody>
                    @foreach ([
            'ano' => 'Ano',
        ] as $attr => $label)
                        <tr>
                            <th>
                                {{ $label }}
                            </th>
                            <td>
                                {{ $compra->$attr }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.compras.edit', $compra) }}" class="btn btn-primary">
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
                            <button type="button" class="btn btn-secondary m-0" data-dismiss="modal">
                                <i class="far fa-times-circle"></i>
                                Cancelar
                            </button>
                            <form action="{{ route('admin.compras.destroy', $compra) }}" method="post">
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

    <div class="card card-light mt-4">
        <div class="card-header">
            <span class="card-title text-lg">Materiais</span>
        </div>
        <div class="card-body">
            <table id="materiais-compra-table" class="table border-bottom table-hover w-100 nowrap">
            </table>
        </div>
    </div>
    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.compras.materiais.create', ['compra' => $compra->ano]) }}"
                class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Adicionar
            </a>
        </div>
    </div>
@endsection

@prepend('scripts')
    <script src="{{ mix('js/datatables.js') }}"></script>
    <script>
        let setores = @js($setores);
        let ano_compra = '{{ $compra->ano }}';

        let table = $('#materiais-compra-table').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            language: {
                url: "{{ asset('datatables/pt-BR.json') }}"
            },
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "POST",
                url: "{{ route('admin.compras.materiais.datatables', $compra) }}",
            },
            order: [1, 'asc'],
            columns: [{
                    title: 'CATMAT',
                    data: 'catmat_material',
                    name: 'materiais.catmat'
                },
                {
                    title: 'Material',
                    data: 'nome_material',
                    name: 'materiais.nome'
                },
                {
                    title: 'Quantidade',
                    data: 'quantidade_total',
                    searchable: false,
                    render: (val, type, data) => {
                        return Number(val).toLocaleString('pt-br');
                    }
                },
                {
                    title: 'Valor unitário',
                    data: 'valor',
                    render: (val, type, data) => {
                        return Number(val).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        });
                    }
                },
                {
                    title: 'Valor total',
                    data: 'valor_total',
                    render: (val, type, data) => {
                        return Number(val).toLocaleString('pt-br', {
                            style: 'currency',
                            currency: 'BRL'
                        });
                    }
                },
                ...setores.map(setor => ({
                    title: setor.nome,
                    data: `quantidade_setor_${setor.id}`,
                    searchable: false,
                    render: (val) => {
                        if (val) {
                            return Number(val).toLocaleString('pt-br');
                        }
                        return val;
                    }
                }))
            ],
            rowCallback: (row, data, index) => {
                let url =
                    "{{ route('admin.compras.materiais.show', ['compra' => '=compra=', 'material' => '=material=']) }}"
                    .replace('=compra=', ano_compra)
                    .replace('=material=', data.catmat_material);

                $(row)
                    .attr('role', 'button')
                    .children()
                    .not('.action-col')
                    .click(() => {
                        window.location.href = url;
                    })
                    .on('auxclick', () => {
                        window.open(url)
                    });
            }
        });
    </script>
@endprepend
