@extends('layouts.main')

@section('style')
    <style>
        .categoria-carousel+.categoria-carousel {
            margin-top: 5rem;
        }

    </style>
@endsection

@section('content')
    @foreach (Categorias::cases() as $categoria)
        <div class="categoria-carousel">
            <h3 class="text-center text-4xl mb-4 mt-6">{{ $categoria->label() }}</h3>
            <div class="show-on-scroll flex mx-auto max-w-screen-2xl carousel">
                <button class="text-5xl my-auto self-start prev">&lsaquo;</button>
                <div class="overflow-hidden mx-3">
                    <div class="slides">
                        <div class="flex min-w-max">
                            @foreach ($perfis[$categoria->name] as $perfil)
                                <div class="border w-80 rounded px-5 py-3 text-center relative hover:bg-slate-400 slide">
                                    <a href="{{ route('perfis.show', $perfil) }}" class="streched-link">
                                        <img src="{{ $perfil->imagem_url }}" alt="{{ $perfil->nome }}"
                                            class="mx-auto mb-3 w-52 h-52">
                                        <h5 class="text-violet-700 text-2xl mb-2">
                                            {{ $perfil->nome }}
                                        </h5>
                                        <p class="text-justify">
                                            {{ $perfil->descricao }}
                                        </p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <button class="text-5xl my-auto ml-auto next">&rsaquo;</button>
            </div>
        </div>
    @endforeach
@endsection
