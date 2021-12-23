<ul>
    @forelse ($perfis as $perfil)
        @php
            if ($advancedSearch ?? false) {
                $perfil = $perfil->model();
            }
        @endphp
        <li class="border-l border-gray-500 pl-8 pr-2 py-2 mb-9 hover:bg-gray-200 overflow-auto">
            <a href="{{ route('perfis.show', $perfil) }}">
                <img src="{{ $perfil->imagem_url }}" alt="{{ $perfil->nome }}" width="120"
                    class="float-left mr-5 my-1.5 w-32 h-32">
                <h5 class="text-violet-700 text-2xl mb-2">
                    {{ $perfil->nome }}
                </h5>
                <p>
                    {{ $perfil->descricao }}
                </p>
            </a>
        </li>
        @if ($loop->last)
            <li class="px-1">
                {{ $perfis->onEachSide(1)->links() }}
            </li>
        @endif
    @empty
        <li class="border-b border-gray-300 pt-2 px-1">
            Nenhum perfil encontrado.
            @if ($search ?? ($advancedSearch ?? false))
                Talvez encontre o que procura realizando uma nova
                <a href="{{ route('perfis.advanced-search.about') }}"
                    class="text-blue-900 hover:text-gray-400 underline">
                    Pesquisa Avançada
                </a>
                .
            @endif
        </li>
    @endforelse
</ul>
