@extends('layouts.main')

@php
$pageTitle = "\"$query\"";
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('partials.content-title', ['contentTitle' => 'Portfólio'])
        <h2 class="text-4xl mb-7">
            Resultados para {{ $pageTitle }}:
        </h2>
        @include('perfis._list', ['search' => true])
    </div>
@endsection
