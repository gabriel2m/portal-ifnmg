@php
if (isset($query)) {
    $pageTitle = "\"$query\"";
}
@endphp

<x-layout :query="$query" :avancada="$avancada" :pageTitle="$pageTitle ?? null">
    <x-slot name="content">
        <div class="mx-auto max-w-screen-lg">
            @include('partials.content-title', ['contentTitle' => 'Portfólio'])
            @if (isset($pageTitle))
                <h2 class="text-4xl mb-7">
                    Resultados {{ $pageTitle }}:
                </h2>
            @endif
            <ul>
                @forelse ($perfis as $perfil)
                    <li class="border-l border-gray-500 pl-8 pr-2 py-2 mb-10 hover:bg-gray-200">
                        <a href="{{ route('perfis.show', ['perfil' => $perfil->id]) }}">
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
                    <li class="border-t border-gray-300 pt-2 px-1">Nenhum perfil encontrado</li>
                @endforelse
            </ul>
        </div>
    </x-slot>
</x-layout>
