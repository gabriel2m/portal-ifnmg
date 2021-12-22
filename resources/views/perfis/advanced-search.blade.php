@extends('layouts.main')

@php
$pageTitle = ["\"$query\"", Perfil::LABELS_CATEGORIAS[$categoria], 'Pesquisa Avançada'];
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        <h2 class="text-5xl text-blue-gray-800">
            Resultados para "{{ $query }}":
        </h2>
        @include('utils.error', ['input' => 'categoria'])
        <div class="mt-4 mb-6 flex flex-wrap justify-between">
            @foreach (Perfil::LABELS_CATEGORIAS as $id => $label)
                <a href="{{ route(Route::currentRouteName(), ['query' => $query, 'categoria' => $id]) }}"
                    class="text-lg underline px-2 pt-1
                    {{ $id == $categoria ? 'bg-blue-500 text-white hover:bg-transparent hover:text-blue-gray-500' : 'text-blue-gray-700 hover:bg-blue-500 hover:text-white' }}
                    ">
                    #{{ $label }}
                </a>
            @endforeach
        </div>
        @include('perfis._list', ['advancedSearch' => true])
    </div>
@endsection
