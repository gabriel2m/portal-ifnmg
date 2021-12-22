@extends('layouts.main')

@section('content')
    <div class="max-w-max mx-auto mt-20 mb-32 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @foreach ([
            [
                'titulo' => 'Prestação de Serviços',
                'descricao' => 'Conheça nossos Laboratórios e Pesquisadores',
                'route' => 'prestacao-servicos',
            ],
            [
                'titulo' => Perfil::LABELS_CATEGORIAS[Perfil::CATEGORIA_EMPRESAS_JUNIOR],
                'descricao' => 'Conheça nossas Empresas Júnior',
                'route' => 'empresas-junior',
            ],
            [
                'titulo' => Perfil::LABELS_CATEGORIAS[Perfil::CATEGORIA_INCUBADORA_TECNOLOGICA],
                'descricao' => 'Incubadora Tecnológica',
                'route' => 'incubadora-tecnologica',
            ],
            [
                'titulo' => Perfil::LABELS_CATEGORIAS[Perfil::CATEGORIA_INSTITUICOES_PARCEIRAS],
                'descricao' => 'Conheça nossas Instituições Parceiras',
                'route' => 'instituicoes-parceiras',
            ],
        ]
        as $item)
            <a href="{{ route('portfolio.' . $item['route']) }}"
                class="border-4 border-gray-300 hover:border-gray-400 p-5 text-blue-gray-700">
                <div class="flex h-32">
                    <h2 class="text-2xl underline uppercase mr-4">{{ $item['titulo'] }}</h2>
                    <i class="icon-arrow-right mb-auto ml-auto mt-1.5"></i>
                </div>
                <p>{{ $item['descricao'] }}</p>
            </a>
        @endforeach
    </div>
@endsection
