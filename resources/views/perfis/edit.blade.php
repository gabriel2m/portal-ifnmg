<x-layout :pageTitle="$perfil->nome.' | Editar'">
    <x-slot name="content">
        <div class="mx-auto max-w-screen-lg">
            @include('partials.content-title', ['contentTitle' => 'Editar Perfil'])
            @include('perfis._save')
        </div>
    </x-slot>
</x-layout>
