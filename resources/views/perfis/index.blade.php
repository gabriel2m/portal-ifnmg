<x-layout>
    <x-slot name="content">
        <div class="mx-auto max-w-screen-lg">
            @include('partials.content-title', ['contentTitle' => 'Portfólio'])
            @include('perfis._list')
        </div>
    </x-slot>
</x-layout>
