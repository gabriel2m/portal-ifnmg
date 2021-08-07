@include('partials.content-title', ['contentTitle' => 'Portfólio', 'margin' => 'mb-2'])
<div class="mb-10 flex flex-wrap text-blue-gray-700">
    @foreach ($categorias as $categoria)
        @php
            $categoriaRouteParams = ['query' => $query ?? null, 'avancada' => $avancada ?? null];
            if (isset($activeCategoria) && $activeCategoria->id === $categoria->id) {
                $categoriaClass = 'bg-blue-500 text-white hover:bg-transparent hover:text-blue-gray-500';
            } else {
                $categoriaClass = 'hover:bg-blue-500 hover:text-white';
                $categoriaRouteParams['categoria'] = $categoria->id;
            }
        @endphp
        <a href="{{ route('perfis.search', $categoriaRouteParams) }}" class="text-lg underline px-2 pt-1 mb-1 {{ $categoriaClass }}">
            #{{ $categoria->categoria }}
        </a>
    @endforeach
</div>
