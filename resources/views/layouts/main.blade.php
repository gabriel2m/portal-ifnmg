<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $pageTitle[] = config('app.name');
    @endphp
    <title>{{ implode(' | ', $pageTitle) }}</title>
    @include('layouts._icomoon-font-face')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="flex flex-col min-h-screen bg-gray-50 text-blue-gray-800">
    <header>
        <nav class="py-1 bg-ifnmg-green-3 custom-row">
            <ul class="max-w-screen-2xl mx-auto flex justify-between flex-wrap text-yellow-50">
                @foreach ([
        [
            'label' => 'Home',
            'route' => 'home',
        ],
        [
            'label' => 'Prestação de Serviços',
            'route' => 'portfolio.prestacao-servicos',
        ],
        [
            'label' => Perfil::LABELS_CATEGORIAS[Perfil::CATEGORIA_EMPRESAS_JUNIOR],
            'route' => 'portfolio.empresas-junior',
        ],
        [
            'label' => Perfil::LABELS_CATEGORIAS[Perfil::CATEGORIA_INCUBADORA_TECNOLOGICA],
            'route' => 'portfolio.incubadora-tecnologica',
        ],
        [
            'label' => Perfil::LABELS_CATEGORIAS[Perfil::CATEGORIA_INSTITUICOES_PARCEIRAS],
            'route' => 'portfolio.instituicoes-parceiras',
        ],
        [
            'label' => 'Cadastrar Perfil',
            'route' => 'perfis.create',
            'show' => Auth::check(),
        ],
        [
            'label' => 'Entre em Contato',
            'route' => 'contact',
            'show' => Auth::guest(),
        ],
        [
            'label' => 'Login',
            'route' => 'login',
            'show' => Auth::guest(),
        ],
    ]
    as $item)
                    @if ($item['show'] ?? true)
                        <x-header-menu-item>
                            <a href="{{ route($item['route']) }}"
                                class="hover:text-gray-400">{{ $item['label'] }}</a>
                        </x-header-menu-item>
                    @endif
                @endforeach
                @auth
                    <x-header-menu-item>
                        <div class="dropdown">
                            <button class="dropdown-toggle hover:text-gray-400 flex">
                                Usuário
                                <div class="leading-none ml-0.5">
                                    &#8964;
                                </div>
                            </button>
                            <ul
                                class="dropdown-menu absolute hidden bg-white text-blue-gray-800 rounded mt-1 border border-gray-400">
                                <x-user-dropdown-item>
                                    <a href="{{ route('user-profile-information.update') }}"
                                        class="px-3">Editar</a>
                                </x-user-dropdown-item>
                                <x-user-dropdown-item>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 w-full">Sair</button>
                                    </form>
                                </x-user-dropdown-item>
                            </ul>
                        </div>
                    </x-header-menu-item>
                @endauth
            </ul>
        </nav>
        @if ($showBanner ?? true)
            <div class="bg-ifnmg-green-1 custom-row">
                <div class="max-w-screen-md mx-auto">
                    <a class="md:flex pb-5 pt-10 hover:no-underline" href="{{ route('home') }}">
                        <img src="{{ asset('img/ifnmg-logo.png') }}" alt="logo ifnmg">
                        <div class="text-white mt-auto ml-3">
                            <h1 class="text-7xl">
                                INPROS
                            </h1>
                            <h2 class="text-4xl">
                                Inovação, Produtos e Serviços
                            </h2>
                        </div>
                    </a>
                    <form action="{{ route('perfis.advanced-search') }}" method="GET">
                        @if (isset($categoria))
                            <input type="hidden" name="categoria" value="{{ $categoria }}">
                        @endif
                        <div class="flex relative">
                            <input
                                class="border border-gray-400 focus:outline-none focus:ring focus:ring-green-200 py-2 pl-3 pr-10 w-full"
                                type="text" name="query" value="{{ old('query', $query ?? '') }}" required>

                            <button type="submit" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">
                                <i class="icon-search text-lg"></i>
                            </button>
                        </div>
                        @include('utils.error', ['input' => 'query', 'color' => 'text-white'])
                    </form>
                    <div class="pb-1">
                        <a href="{{ route('perfis.advanced-search.about') }}"
                            class="text-white hover:text-green-300 underline text-sm">
                            saiba mais sobre a pesquisa avançada
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </header>

    <div>
        @php
            $flash = [
                'success' => [
                    'label' => 'Sucesso!',
                    'icon' => 'checkmark',
                    'color' => 'green',
                ],
                'warning' => [
                    'label' => 'Atenção!',
                    'icon' => 'warning',
                    'color' => 'yellow',
                ],
                'status' => [
                    'label' => 'Status',
                    'icon' => 'info',
                    'color' => 'blue',
                ],
            ];
            // Avoid prune:
            // bg-green-100  border-green-800  text-green-900  text-green-500
            // bg-yellow-100 border-yellow-800 text-yellow-900 text-yellow-500
            // bg-blue-100   border-blue-800   text-blue-900   text-blue-500
        @endphp
        @foreach (session()->all() as $type => $flashMessage)
            @if (Arr::has($flash, $type))
                <div class="bg-{{ $flash[$type]['color'] }}-100 border-t-2 border-{{ $flash[$type]['color'] }}-800 text-{{ $flash[$type]['color'] }}-900 px-4 py-3 shadow-md mt-3 mx-auto max-w-screen-lg close-target"
                    role="alert">
                    <div class="flex">
                        <div class="py-1">
                            <i
                                class="icon-{{ $flash[$type]['icon'] }} text-{{ $flash[$type]['color'] }}-500 mr-4 text-2xl"></i>
                        </div>
                        <div>
                            <p class="font-bold">{{ $flash[$type]['label'] }}</p>
                            <p class="text-sm">{{ __($flashMessage) }}</p>
                        </div>
                        <div class="ml-auto">
                            <button class="close-btn text-xs text-gray-500 hover:text-gray-700">
                                <i class="icon-cross"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <main class="pt-12 pb-16 custom-row">
        @yield('content')
    </main>

    <footer class="mt-auto">
        <div class="py-5 custom-row bg-ifnmg-green-3 flex justify-evenly flex-wrap">
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
            'icon' => 'icon-facebook2',
            'label' => 'IFNMG Campus Januária',
        ],
    ]
    as $item)
                <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer"
                    class="text-white hover:text-green-300 relative m-2">
                    <i class="{{ $item['icon'] }} text-2xl absolute"></i>
                    <span class="ml-7">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
        <div class="text-green-100 pt-9 pb-3 bg-ifnmg-green-2 custom-row">
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
                    Qual a sua demanda?
                    <a href="{{ route('contact') }}" class="hover:text-white">
                        <span class="underline">Entre em contato aqui</span>
                        <i class="icon-pencil2"></i>
                    </a>
                </div>
                <div class="text-xs mt-auto">
                    Desenvolvedor:
                    <a href="https://linktr.ee/gabriel2m" target="_blank" rel="noopener noreferrer"
                        class="hover:text-white underline">
                        @gabriel2m
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
