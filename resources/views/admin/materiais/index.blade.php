@extends('admin.materiais.base')

@prepend('styles')
    <link rel="stylesheet" href="{{ mix('css/datatables.css') }}">
@endprepend

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="materiais-table" class="table border-bottom table-hover w-100 nowrap">
            </table>
        </div>
    </div>
    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.materiais.create') }}" class="btn btn-primary">
                <i class="la-lg las la-plus"></i>
                Adicionar
            </a>
        </div>
    </div>
@endsection

@prepend('scripts')
    <script src="{{ mix('js/datatables.js') }}"></script>
    <script>
        let tipos = @js(TipoMaterial::labels());

        let table = $('#materiais-table').DataTable({
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
                url: "{{ route('admin.materiais.datatables') }}",
            },
            order: [1, 'asc'],
            columns: [{
                    title: 'CATMAT',
                    data: 'catmat'
                },
                {
                    title: 'Nome',
                    data: 'nome'
                },
                {
                    title: 'Tipo',
                    data: 'tipo',
                    render: (val) => tipos[val]
                },
                {
                    title: 'Descrição',
                    data: 'descricao'
                },
            ],
            rowCallback: (row, data, index) => {
                let url = "{{ route('admin.materiais.show', '=catmat=') }}".replace('=catmat=', data.catmat)
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
