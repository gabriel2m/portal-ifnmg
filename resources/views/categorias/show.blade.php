@extends('layouts.main')

@php
$pageTitle = array_filter([isset($filtro) ? "\"$filtro\"" : false, $categoria->label()]);
$categoriaSearch = $categoria;
@endphp

@section('content')
    <div class="max-w-screen-lg mx-auto">
        <h3 class="border-b border-gray-500 pb-0.5 uppercase">
            {{ $categoria->label() }}
        </h3>
        <div class="py-4 px-5 bg-green-200 my-1">
            {{ $categoria->descricao() }}
        </div>
        <form action="{{ route(Route::currentRouteName(), ['slug' => $categoria->slug()]) }}" method="GET">
            <div class="flex">
                <input class="input-primary" type="text" name="filtro" value="{{ old('filtro', $filtro) }}">

                <button type="submit" class="px-4 border border-gray-400 text-slate-700 hover:bg-slate-600 hover:text-white">
                    Filtrar
                </button>
            </div>
            @include('utils.error', ['input' => 'filtro'])
        </form>
        <div class="mt-5"></div>
        @include('perfis._list', ['search' => isset($filtro)])
    </div>
@endsection
