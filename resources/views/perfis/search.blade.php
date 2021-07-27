@php
$pageTitle = "\"$query\"";
@endphp
<x-layout :pageTitle="$pageTitle" :query="$query" :avancada="$avancada">
    <x-slot name="content">
        <div class="mx-auto max-w-screen-lg">
            @include('partials.content-title', ['contentTitle' => 'Portfólio'])
            <h2 class="text-4xl mb-7">
                Resultados para {{ $pageTitle }}:
            </h2>
            @include('perfis._list', ['search' => true])
        </div>
    </x-slot>
</x-layout>
