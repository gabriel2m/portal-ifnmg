@extends('admin.compras.base')

@prepend('styles')
    <link rel="stylesheet" href="{{ mix('css/datatables.css') }}">
@endprepend

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="compras-table" class="table border-bottom table-hover w-100 nowrap">
            </table>
        </div>
    </div>
    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.compras.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Adicionar
            </a>
        </div>
    </div>
@endsection

@prepend('scripts')
    <script src="{{ mix('js/datatables.js') }}"></script>
    <script>
        let table = $('#compras-table').DataTable({
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
                url: "{{ route('admin.compras.datatables') }}",
            },
            order: [0, 'desc'],
            columns: [{
                title: 'Ano',
                data: 'ano'
            }],
            rowCallback: (row, data, index) => {
                let url = "{{ route('admin.compras.show', '=ano=') }}".replace('=ano=', data.ano)
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
