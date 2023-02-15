@extends('layouts.main')

@php
    $title = ["\"$query\"", $categoria->label(), 'Pesquisa Avançada'];
    $categoriaSearch = $categoria;
@endphp

@section('main-content')
    <div class="mx-auto max-w-screen-lg">
        @component('utils.content-title')
            @slot('text')
                Resultados para "<span class="italic">{{ $query }}</span>":
            @endslot
        @endcomponent
        @include('utils.error', ['input' => 'categoria'])
        <div class="mt-4 mb-6 flex flex-wrap justify-between">
            @foreach (Categorias::cases() as $case)
                <a href="{{ route(Route::currentRouteName(), ['query' => $query, 'categoria' => $case->value]) }}"
                    class="text-lg underline px-2 pt-1
                    {{ $case == $categoria ? 'bg-blue-500 text-white hover:bg-transparent hover:text-slate-500' : 'text-slate-700 hover:bg-blue-500 hover:text-white' }}
                    ">
                    #{{ $case->label() }}
                </a>
            @endforeach
        </div>
        @include('perfis._list', ['advancedSearch' => true])
    </div>
@endsection
