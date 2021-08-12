@extends('layouts.main')

@php
if (isset($query)) {
    $pageTitle[] = "\"$query\"";
}
if (isset($activeCategoria)) {
    $pageTitle[] = $activeCategoria->categoria;
}
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.portfolio-header')
        @if (isset($query))
            <h2 class="text-4xl mb-7">
                Resultados para "{{ $query }}":
            </h2>
        @endif
        @include('perfis._list', ['search' => true])
    </div>
@endsection
