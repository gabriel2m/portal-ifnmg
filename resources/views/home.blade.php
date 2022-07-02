@extends('layouts.main')

@section('head')
    <style>
        .categoria-carousel+.categoria-carousel {
            margin-top: 5rem;
        }
    </style>
@endsection

@section('content')
    @foreach (Categorias::cases() as $categoria)
        <div class="categoria-carousel hidden">
            <h3 class="text-center mb-4 mt-6">{{ $categoria->label() }}</h3>
            <div class="show-on-scroll flex mx-auto max-w-screen-2xl carousel">
                <button class="text-5xl my-auto self-start prev">&lsaquo;</button>
                <div class="overflow-hidden mx-3">
                    <div class="slides flex min-w-max">
                    </div>
                </div>
                <button class="text-5xl my-auto ml-auto next" page="1"
                    categoria="{{ $categoria->value }}">&rsaquo;</button>
            </div>
        </div>
    @endforeach
    <template id="loading">
        <svg class="animate-spin h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </template>
    <template id="perfil-card">
        <div class="border w-80 rounded px-5 py-3 text-center relative hover:bg-slate-400 slide">
            <a href="{-link-}" class="streched-link">
                <img src="{-imagem_url-}" alt="{-nome-}" class="mx-auto mb-3 w-52 h-52">
                <h5 class="text-violet-700 mb-2">
                    {-nome-}
                </h5>
                <p class="text-justify">
                    {-descricao-}
                </p>
            </a>
        </div>
    </template>
@endsection

@section('extra-js')
    <script>
        function next_categoria_page(button) {
            const carousel = button.closest('.categoria-carousel')
            if (!button.classList.contains('loading') && button.getAttribute('page')) {
                button.classList.add('loading')
                const innerHTML = button.innerHTML
                button.innerHTML = document.querySelector('#loading').innerHTML
                axios.get('/api/perfis', {
                    params: {
                        page: button.getAttribute('page'),
                        categoria: button.getAttribute('categoria')
                    }
                }).then(res => {
                    button.classList.remove('loading')
                    button.innerHTML = innerHTML
                    const slides = carousel.querySelector('.slides')
                    const perfil_card = document.querySelector('#perfil-card').innerHTML.toString()
                    const parser = new DOMParser()
                    for (const perfil of res.data.data) {
                        let current_card = perfil_card
                        for (const attr in perfil)
                            current_card = current_card.replaceAll(`{-${attr}-}`, perfil[attr])
                        slides.append(parser.parseFromString(current_card, "text/html").body.firstElementChild)
                    }
                    if (res.data.links.next)
                        button.setAttribute('page', Number(button.getAttribute('page')) + 1)
                    else
                        button.removeAttribute('page')
                    carousel.classList.remove('hidden')
                })
            }
        }

        document.querySelectorAll('.categoria-carousel .next').forEach(button => {
            next_categoria_page(button)
            button.addEventListener('click', event => {
                next_categoria_page(event.target)
            })
        })
    </script>
@endsection
