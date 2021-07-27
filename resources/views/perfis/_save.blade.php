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
    </div>
    <div>
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="nome">
            Descrição
        </label>

        <textarea name="descricao" class="w-full text-sm border border-gray-400 focus:outline-none focus:ring py-2 px-3"
            rows="10" required>{{ old('descricao') ?? $perfil->descricao }}</textarea>

        @error('descricao')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end mt-6 pt-6 px-3 border-t border-gray-200">
        <x-primary-button>
            Salvar
        </x-primary-button>
    </div>
</form>
