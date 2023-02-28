@extends('admin.users.base')

@prepend('styles')
    <link rel="stylesheet" href="{{ mix('css/datatables.css') }}">
@endprepend

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="users-table" class="table border-bottom table-hover w-100 nowrap">
            </table>
        </div>
    </div>
    <div class="d-flex mt-3">
        <div class="ml-auto">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Adicionar
            </a>
        </div>
    </div>
@endsection

@prepend('scripts')
    <script src="{{ mix('js/datatables.js') }}"></script>
    <script>
        let niveis = @js(NivelUser::labels());

        let table = $('#users-table').DataTable({
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
                url: "{{ route('admin.users.datatables') }}",
            },
            columns: [{
                    title: 'Usuário',
                    data: 'name'
                },
                {
                    title: 'Nível',
                    data: 'nivel',
                    render: nivel => niveis[nivel]
                },
                {
                    title: 'Email',
                    data: 'email'
                },
            ],
            rowCallback: (row, data, index) => {
                let url = "{{ route('admin.users.show', '=id=') }}".replace('=id=', data.id)
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
