<table class="table-primary w-full mb-3">
    <thead>
        <tr class="font-mono">
            @php
                $cols = $attrs;
                $actions = [];
                foreach (
                    [
                        'show' => 'Abrir',
                        'edit' => 'Editar',
                        'destroy' => 'Deletar',
                    ]
                    as $action => $label
                ) {
                    if ($actions[$action] = Route::has("$resource_name.$action")) {
                        $cols[] = $label;
                    }
                }
                $cols_count = count($cols);
            @endphp
            @foreach ($cols as $col)
                <th class="font-normal">
                    {{ $col }}
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php($actionButtonClass = 'hover:text-white hover:border-0 hover:bg-gray-300 p-2 border')
        @forelse ($models as $model)
            <tr class="text-center">
                @foreach (array_keys($attrs) as $index => $attr)
                    <td @class([
                        'text-left',
                        'font-bold' => $index == 0,
                        'whitespace-nowrap' => $index == 0,
                    ])>
                        {{ $model->$attr }}
                    </td>
                @endforeach
                @if ($actions['show'])
                    <td>
                        <div class="p-1">
                            <a href="{{ route("$resource_name.show", $model) }}">
                                <i class="icon-see border-blue-500 {{ $actionButtonClass }}"></i>
                            </a>
                        </div>
                    </td>
                @endif
                @if ($actions['edit'])
                    <td>
                        <div class="p-1">
                            <a href="{{ route("$resource_name.edit", $model) }}">
                                <i class="icon-edit border-yellow-500 {{ $actionButtonClass }}"></i>
                            </a>
                        </div>
                    </td>
                @endif
                @if ($actions['destroy'])
                    <td>
                        <form action="{{ route("$resource_name.destroy", $model) }}" method="POST"
                            onsubmit="return confirm('Deseja realmente deletar esse elemento?')" class="p-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                <i class="icon-cross border-red-500 {{ $actionButtonClass }}"></i>
                            </button>
                        </form>
                    </td>
                @endif
            </tr>
            @if ($loop->last && $models instanceof Illuminate\Contracts\Pagination\Paginator)
                <tr>
                    <td colspan="{{ $cols_count }}">
                        {{ $models->onEachSide(1)->links() }}
                    </td>
                </tr>
            @endif
        @empty
            <tr>
                <td colspan="{{ $cols_count }}" class="italic text-center">
                    Nenhum elemento encontrado
                </td>
            </tr>
        @endforelse
        <tr>
            <td colspan="{{ $cols_count }}" class="text-center">
                <div class="m-1.5">
                    <a href="{{ route("$resource_name.create") }}">
                        <i class="icon-plus rounded-full border-green-600 {{ $actionButtonClass }}"
                            title="Adicionar"></i>
                    </a>
                </div>
            </td>
        </tr>
    </tbody>
</table>
