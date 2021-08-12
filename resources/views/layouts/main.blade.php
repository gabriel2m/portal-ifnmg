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
        <nav class="py-7 bg-gray-800 custom-row">
            <ul class="flex justify-between text-yellow-50">
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('perfis.create') }}">Cadastrar Perfil</a>
                </li>
            </ul>
        </nav>
        <div class="pt-80 pb-1 bg-green-600 custom-row">
            TODO: Banner
            <form action="{{ route('perfis.search', $activeCategoria ?? null) }}" method="GET"
                class="max-w-screen-lg mx-auto">
                <div class="flex relative">
                    <input
                        class="border border-gray-400 focus:outline-none focus:ring focus:ring-green-200 py-2 px-3 w-full"
                        type="text" name="query" id="query" value="{{ old('query') ?? ($query ?? '') }}">

                    <button type="submit" class="absolute right-3 top-3 text-gray-500 hover:text-gray-700">
                        <i class="icon-search text-lg"></i>
                    </button>
                </div>
                @include('utils.errors', ['inputs' => ['query'], 'textColor' => 'text-white'])
                <div>
                    <input type="checkbox" id="avancada" name="avancada" @if ($avancada ?? false) checked @endif value="1">
                    <label for="avancada" class="text-white hover:text-gray-300 underline">
                        <a href="{{ route('pesquisa-avancada') }}">pesquisa avançada?</a>
                    </label>
                </div>
                @include('utils.errors', ['inputs' => ['avancada'], 'textColor' => 'text-white'])
            </form>
        </div>
    </header>

    <div>
        @php
            $flashes = [];
            if (session()->has('success')) {
                $flashes[] = [
                    'label' => 'Sucesso!',
                    'icon' => 'icon-checkmark',
                    'color' => 'green',
                    'message' => session('success'),
                ];
            }
            if (session()->has('warning')) {
                $flashes[] = [
                    'label' => 'Atenção!',
                    'icon' => 'icon-warning',
                    'color' => 'yellow',
                    'message' => session('warning'),
                ];
            }
            // Comment to avoid prod prune
            // bg-green-100
            // border-green-800
            // text-green-900
            // text-green-500
            // bg-yellow-100
            // border-yellow-800
            // text-yellow-900
            // text-yellow-500
        @endphp
        @foreach ($flashes as $flash)
            <div class="bg-{{ $flash['color'] }}-100 border-t-2 border-{{ $flash['color'] }}-800 text-{{ $flash['color'] }}-900 px-4 py-3 shadow-md mt-3 mx-auto max-w-screen-lg close-target"
                role="alert">
                <div class="flex">
                    <div class="py-1">
                        <i class="{{ $flash['icon'] }} text-{{ $flash['color'] }}-500 mr-4 text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-bold">{{ $flash['label'] }}</p>
                        <p class="text-sm">{{ $flash['message'] }}</p>
                    </div>
                    <div class="ml-auto">
                        <button class="close-btn text-xs text-gray-500 hover:text-gray-700">
                            <i class="icon-cross"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <main class="py-10 custom-row">
        @yield('content')
    </main>

    <footer class="mt-auto">
        <div class="py-7 bg-green-800 custom-row">
            TODO: Links
        </div>
        <div class="py-2 bg-green-600 custom-row">
            TODO: Instituição
        </div>
    </footer>

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
