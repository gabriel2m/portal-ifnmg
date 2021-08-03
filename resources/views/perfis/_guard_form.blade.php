<form method="POST" action="{{ $perfil->exists ? route('perfis.update', $perfil) : route('perfis.store') }}"
    autocomplete="off">
    @csrf
    @if ($perfil->exists)
        @method('PUT')
    @endif
    <div class="mb-6">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="nome">
            Nome
        </label>

        <input class="w-full border border-gray-400 focus:outline-none focus:ring py-2 px-3" type="text" name="nome"
            id="nome" value="{{ old('nome') ?? $perfil->nome }}" required>

        @error('nome')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
        @include('partials.errors', ['inputs' => ['nome']])
    </div>
    <div class="mb-5">
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="categorias">
            Categorias
        </label>
        <div id="categorias" class="grid grid-cols-3 gap-2">
            @foreach ($categorias as $categoria)
                <div>
                    <input type="checkbox" id="categoria-{{ $loop->iteration }}" name="categorias[]"
                        value="{{ $categoria->id }}" @if ($perfil->categorias->contains($categoria)) checked @endif>
                    <label for="categoria-{{ $loop->iteration }}">
                        {{ $categoria->categoria }}
                    </label>
                </div>
            @endforeach
        </div>
        @include('partials.errors', ['inputs' => ['categorias', 'categorias.*']])
    </div>
    <div>
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="descricao">
            Descrição
        </label>

        <textarea name="descricao" class="w-full text-sm border border-gray-400 focus:outline-none focus:ring py-2 px-3"
            rows="10" required>{{ old('descricao') ?? $perfil->descricao }}</textarea>

        @include('partials.errors', ['inputs' => ['descricao']])
    </div>

    <div class="flex mt-6 pt-6 px-3 border-t border-gray-200">
        @if ($perfil->exists)
            <a href="{{ route('perfis.show', $perfil) }}" class="text-gray-500 hover:text-gray-700 underline mr-auto">
                Voltar
            </a>
        @endif
        <div class="ml-auto">
            <x-primary-button>
                Salvar
            </x-primary-button>
        </div>
    </div>
</form>
