@extends('layouts.admin')

@php
$pageTitle = $setor->exists ? [$setor->nome, 'Editar Setor'] : ['Adicionar Setor'];
@endphp

@section('content')
    @include('admin.utils.content-title', [
        'text' => $setor->exists ? $pageTitle[1] : null,
    ])
    <div class="mx-auto max-w-screen-lg">
        <form method="POST"
            action="{{ $setor->exists ? route('admin.setores.update', $setor) : route('admin.setores.store') }}"
            class="form-primary" autocomplete="off">
            @csrf
            @if ($setor->exists)
                @method('PUT')
            @endif
            <div>
                <label class="label-primary" for="nome">
                    Setor
                </label>
                <input type="text" name="nome" class="input-primary" value="{{ old('nome', $setor->nome) }}" required>
                @include('utils.error', ['input' => 'nome'])
            </div>
            @include('admin.utils.form-footer')
        </form>
    </div>
@endsection
