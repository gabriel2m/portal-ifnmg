<ul>
    @forelse ($perfis as $perfil)
        <li class="border-l border-gray-500 pl-8 pr-2 py-2 mb-10 hover:bg-gray-200">
            <a href="{{ route('perfis.show', $perfil) }}">
                <div>
                    <h5 class="text-violet-700 text-2xl mb-3">
                        {{ $perfil->nome }}
                    </h5>
                    <p>
                        {{ $perfil->descricao }}
                    </p>
                </div>
            </a>
        </li>
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
