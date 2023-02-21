@extends('admin.materiais.base')

@prepend('styles')
    <link rel="stylesheet" href="{{ mix('css/datatables.css') }}">
@endprepend

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="materiais-table" class="table border-bottom border-top-0 table-hover w-100">
            </table>
        </div>
    </div>
@endsection

@prepend('scripts')
    <script src="{{ mix('js/datatables.js') }}"></script>
    <script>
        let table = $('#materiais-table').DataTable({
            processing: true,
            serverSide: true,
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
                    title: 'Descrição',
                    data: 'descricao'
                },
            ]
        });
    </script>
@endprepend
