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
                    <tr>
                        <th>
                            Ano
                        </th>
                        <td>
                            {{ $compra->ano }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.compras.edit', $compra) }}" class="btn btn-primary">
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
                            <form action="{{ route('admin.compras.destroy', $compra) }}" method="post">
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

    <div class="card card-outline card-secondary mt-4">
        <div class="card-header">
            <span class="card-title">Materiais permanentes</span>
        </div>
        <div class="card-body">
            <table id="permanente-table" class="table border-bottom table-hover w-100 nowrap">
            </table>
        </div>
    </div>

    <div class="card card-outline card-secondary mt-4">
        <div class="card-header">
            <span class="card-title">Materiais de consumo</span>
        </div>
        <div class="card-body">
            <table id="consumo-table" class="table border-bottom table-hover w-100 nowrap">
            </table>
        </div>
    </div>

    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.compras.materiais.create', ['compra' => $compra->ano]) }}" class="btn btn-primary">
                <i class="la-lg las la-plus"></i>
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

        let table_config = () => ({
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
                    name: 'materiais.nome',
                },
                {
                    title: 'Unidade de medida',
                    data: 'unidade_material',
                    name: 'unidades.nome',
                },
                {
                    title: 'Quantidade total',
                    data: 'quantidade_total',
                    searchable: false,
                    render: (val, type, data) => Number(val).toLocaleString('pt-br')
                },
                ...setores.map(setor => ({
                    title: setor.nome,
                    data: `quantidade_setor_${setor.id}`,
                    searchable: false,
                    render: val => val ? Number(val).toLocaleString('pt-br') : val
                }))
            ],
            rowCallback: (row, data, index) => {
                let url =
                    "{{ route('admin.compras.materiais.show', ['compra' => '=compra=', 'material' => '=material=']) }}"
                    .replace('=compra=', ano_compra)
                    .replace('=material=', data.material_unidade_id);

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

        let permanente_table_config = table_config();
        let consumo_table_config = table_config();

        permanente_table_config.ajax.data = body => {
            body.tipo = '{{ TipoMaterial::Permanente->value }}';
        };
        consumo_table_config.ajax.data = body => {
            body.tipo = '{{ TipoMaterial::Consumo->value }}';
        };

        let permanente_table = $('#permanente-table').DataTable(permanente_table_config);
        let consumo_table = $('#consumo-table').DataTable(consumo_table_config);
    </script>
@endprepend
