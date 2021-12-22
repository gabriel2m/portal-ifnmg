@extends('layouts.main')

@php
$pageTitle = array_filter([isset($filtro) ? "\"$filtro\"" : false, $titulo]);
@endphp

@section('content')
    <div class="max-w-screen-lg mx-auto">
        <h2 class="text-blue-gray-800 text-4xl border-b border-gray-500 pb-0.5 uppercase">
            {{ $titulo }}
        </h2>
        <div class="py-3 px-5 bg-green-200 mt-0.5">
            {{ $descricao }}
        </div>
        <form action="{{ route(Route::currentRouteName()) }}" method="GET" class="mt-1">
            <input type="hidden" name="categoria" value="{{ $categoria }}">
            <div class="flex">
                <input class="w-full border border-gray-400 focus:outline-none focus:ring-2 py-2 px-3" type="text"
                    name="filtro" value="{{ old('filtro', $filtro) }}">

                <button type="submit"
                    class="px-4 border border-gray-400 text-blue-gray-700 hover:bg-blue-gray-600 hover:text-white">
                    Filtrar
                </button>
            </div>
            @include('utils.error', ['input' => 'filtro'])
        </form>
        @if (isset($categorias))
            @include('utils.error', ['input' => 'categoria'])
            <div class="max-w-screen-md mx-auto flex justify-evenly mt-2.5">
                @foreach ($categorias as $id)
                    <a href="{{ route('portfolio.prestacao-servicos', ['filtro' => $filtro, 'categoria' => $id]) }}"
                        class="text-lg underline px-2 pt-1 pb-0.5
                {{ $id == $categoria ? 'bg-blue-500 text-white hover:bg-transparent hover:text-blue-gray-500' : 'text-blue-gray-700 hover:bg-blue-500 hover:text-white' }}
                ">
                        #{{ Perfil::LABELS_CATEGORIAS[$id] }}
                    </a>
                @endforeach
            </div>
        @endif
        <div class="mt-5"></div>
        @include('perfis._list', ['search' => isset($filtro)])
    </div>
@endsection
