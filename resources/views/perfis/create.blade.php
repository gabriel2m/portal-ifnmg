@php
    $contentTitle = "Novo Perfil"
@endphp
<x-layout :pageTitle="$contentTitle">
    <x-slot name="content">
        <div class="mx-auto max-w-screen-lg">
            @include('partials.content-title')
            @include('perfis._save')
        </div>
    </x-slot>
</x-layout>
