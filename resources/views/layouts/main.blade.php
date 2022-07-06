@extends('layouts.base')

@section('header')
    <header>
        <nav class="py-1 bg-ifnmg-green-2 app-row">
            <ul class="max-w-screen-2xl mx-auto flex justify-between flex-wrap text-yellow-50">
                @foreach ([
            [
                'label' => 'Home',
                'route' => ['home'],
            ],
            ...array_map(function ($categoria) {
                return [
                    'label' => $categoria->label(),
                    'route' => ['categorias.show', ['slug' => $categoria->slug()]],
                ];
            }, Categorias::cases()),
            [
                'label' => 'Cadastrar Perfil',
                'route' => ['perfis.create'],
                'show' => Auth::check(),
            ],
            [
                'label' => 'Área Administrativa',
                'route' => ['admin.home'],
                'show' => Auth::check(),
            ],
            [
                'label' => 'Entre em Contato',
                'route' => ['contato.show'],
                'show' => Auth::guest(),
            ],
            [
                'label' => 'Login',
                'route' => ['login'],
                'show' => Auth::guest(),
            ],
            [
                'label' => 'Usuário',
                'items' => [
                    [
                        'label' => 'Editar',
                        'route' => ['user-profile-information.update'],
                    ],
                    [
                        'label' => 'Sair',
                        'route' => ['logout'],
                        'post' => true,
                    ],
                ],
                'show' => Auth::check(),
            ],
        ]
        as $item)
                    @if ($item['show'] ?? true)
                        <li class="mx-3 my-2 hover:text-green-300">
                            @if (array_key_exists('items', $item))
                                <div class="dropdown">
                                    <button class="dropdown-toggle flex">
                                        {{ $item['label'] }}
                                        <div class="leading-none ml-0.5">
                                            &#8964;
                                        </div>
                                    </button>
                                    <ul
                                        class="dropdown-menu absolute hidden bg-white text-slate-800 rounded mt-1 border border-gray-400">
                                        @foreach ($item['items'] as $subitem)
                                            <li class="my-2 hover:bg-gray-300">
                                                @if ($subitem['post'] ?? false)
                                                    <form action="{{ route(...$subitem['route']) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="px-3 w-full">
                                                            {{ $subitem['label'] }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ route(...$subitem['route']) }}" class="px-3">
                                                        {{ $subitem['label'] }}
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route(...$item['route']) }}">
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
        @if ($showBanner ?? true)
            <div class="bg-ifnmg-green-1 app-row">
                <div class="max-w-screen-md mx-auto">
                    <div class="pb-5 pt-10">
                        <a class="md:flex" href="{{ route('home') }}">
                            <img src="{{ asset('img/ifnmg-logo.png') }}" alt="logo ifnmg" width="170">
                            <div class="text-white mt-auto ml-3">
                                <h1 class="text-6xl">
                                    {{ config('app.name') }}
                                </h1>
                                <h4>
                                    Serviços, Inovação e Produtos
                                </h4>
                            </div>
                        </a>
                    </div>
                    <form action="{{ route('perfis.pesquisa-avancada.show') }}" method="GET">
                        @if (isset($categoriaSearch))
                            <input type="hidden" name="categoria" value="{{ $categoriaSearch->value }}">
                        @endif
                        <div class="flex relative">
                            <input
                                class="w-full border border-gray-400 focus:outline-none focus:ring-2 focus:ring-green-200 py-2 pl-3 pr-10"
                                type="text" name="query" value="{{ old('query', $query ?? '') }}" required>

                            <button type="submit" class="absolute right-3 top-2 text-gray-500 hover:text-gray-700">
                                <i class="icon-search text-lg"></i>
                            </button>
                        </div>
                        @foreach (['query', 'categoria'] as $input)
                            @include('utils.error', [
                                'input' => $input,
                                'color' => 'text-white',
                                'class' => 'bg-red-600 p-1',
                            ])
                        @endforeach
                    </form>
                    <div class="pb-1">
                        <a href="{{ route('perfis.pesquisa-avancada.about') }}"
                            class="text-white hover:text-green-300 underline text-sm">
                            saiba mais sobre a pesquisa avançada
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </header>
@endsection

@section('main')
    @include('utils.flash-messages')
    <main class="pt-12 pb-16 app-row">
        @yield('content')
    </main>
@endsection

@section('footer')
    <footer class="mt-auto">
        <div class="py-3 app-row bg-ifnmg-green-3 flex justify-evenly flex-wrap">
            @foreach ([
            [
                'link' => 'https://www.youtube.com/user/IFNMGJanuaria',
                'icon' => 'icon-youtube',
                'label' => 'IFNMG Campus Januária',
            ],
            [
                'link' => 'https://ifnmg.edu.br/januaria',
                'icon' => 'icon-blog',
                'label' => 'Portal IFNMG - Januária',
            ],
            [
                'link' => 'https://www.instagram.com/ifnmg_januaria',
                'icon' => 'icon-instagram',
                'label' => 'ifnmg_januaria',
            ],
            [
                'link' => 'https://www.facebook.com/ifnmgjanuaria',
                'icon' => 'icon-facebook',
                'label' => 'IFNMG Campus Januária',
            ],
        ]
        as $item)
                <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer"
                    class="text-white hover:text-green-300 m-2 flex">
                    <i class="{{ $item['icon'] }} text-2xl"></i>
                    <span class="my-auto ml-1">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
        <div class="text-green-100 pt-7 pb-3 bg-ifnmg-green-2 app-row">
            <div class="text-center text-sm mb-2">
                Fazenda São Geraldo, S/N Km 06 - 39480-000 - Januária / MG
                <br>
                Telefone: (38) 3629-4600
                <br>
                E-mail: comunicacao.januaria@ifnmg.edu.br
                <br>
                IFNMG - Januária
            </div>
            <div class="flex justify-between flex-wrap">
                <div class="my-3 sm:my-0">
                    Qual é sua demanda?
                    <a href="{{ route('contato.show') }}" class="hover:text-white">
                        <span class="underline">Clique aqui e entre em contato</span>
                        <i class="icon-pencil"></i>
                    </a>
                </div>
                <div class="text-sm mt-auto">
                    Desenvolvedor:
                    <a href="https://linktr.ee/gabriel2m" target="_blank" rel="noopener noreferrer"
                        class="hover:text-white underline">
                        @gabriel2m
                    </a>
                </div>
            </div>
        </div>
    </footer>
@endsection
