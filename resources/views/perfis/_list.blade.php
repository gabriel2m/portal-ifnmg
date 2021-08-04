<ul>
    @forelse ($perfis as $perfil)
        @php
            if ($avancada ?? false) {
                $perfil = $perfil->model();
            }
        @endphp
        <li class="border-l border-gray-500 pl-8 pr-2 py-2 mb-10 hover:bg-gray-200">
            <a href="{{ route('perfis.show', $perfil) }}">
                <div>
                    <h5 class="text-violet-700 text-2xl mb-0">
                        {{ $perfil->nome }}
                    </h5>
                    <span class="italic text-sm text-gray-500">
                        {{ $perfil->categorias_label }}
                    </span>
                    <p class="mt-3.5">
                        {{ $perfil->descricao }}
                    </p>
                </div>
            </a>
        </li>
        @if ($loop->last)
            <li class="px-1">
                {{ $perfis->links() }}
            </li>
        @endif
    @empty
        <li class="border-b border-gray-300 pt-2 px-1">
            Nenhum perfil encontrado.
            @if ($search ?? false)
                Talvez encontre o que procura realizando uma nova
                <a href="{{ route('pesquisa-avancada') }}" class="text-blue-900 hover:text-gray-300 underline">
                    Pesquisa Avançada
                </a>
                .
            @endif
        </li>
    @endforelse
</ul>
