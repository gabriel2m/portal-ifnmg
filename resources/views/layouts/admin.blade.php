@extends('layouts.base')

@php
    $title[] = 'Área Administrativa';
@endphp

@prepend('styles')
@endprepend

@section('content')
    <main class="flex">
        <div class="bg-ifnmg-green-2 py-5 px-10 text-white w-72 min-h-screen shadow shadow-black">
            <a href="{{ route('admin.home') }}" class="flex flex-col items-center">
                <img src="{{ asset('img/ifnmg-logo.png') }}" alt="logo ifnmg" class="h-36">
                <h4>{{ config('app.name') }}</h4>
            </a>
            <ul class="mt-4 text-center space-y-5 font-sans">
                @foreach ([
            [
                'route' => ['admin.materiais.index'],
                'label' => 'Materiais',
            ],
            [
                'route' => ['admin.unidades.index'],
                'label' => 'Unidades',
            ],
            [
                'route' => ['admin.setores.index'],
                'label' => 'Setores',
            ],
            [
                'route' => ['home'],
                'label' => '&lsaquo;&lsaquo; Portal',
            ],
        ] as $item)
                    <li
                        class="relative p-2 z-10 outline outline-1
                        after:absolute after:w-full after:h-full after:top-2 after:-left-2 after:-z-50 after:bg-green-800 after:transition-all
                        after:hover:top-0 after:hover:left-0">
                        <a href="{{ route(...$item['route']) }}" class="streched-link">
                            {!! $item['label'] !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="w-full">
            @include('utils.flash-messages')
            <div class="px-20 py-8 text-slate-600">
                @yield('main-content')
            </div>
        </div>
    </main>
    <footer class="mt-auto bg-ifnmg-green-3 text-white text-center p-2">
        {{ config('app.name') }} | IFNMG
    </footer>
@endsection

@prepend('scripts')
@endprepend
