@extends('layouts.admin')

@php
$title = $unidade->exists ? [$unidade->nome, 'Editar Unidade'] : ['Adicionar Unidade'];
@endphp

@section('main-content')
    @include('admin.utils.content-title', [
        'text' => $unidade->exists ? $title[1] : null,
    ])
    <div class="mx-auto max-w-screen-lg">
        <form method="POST"
            action="{{ $unidade->exists ? route('admin.unidades.update', $unidade) : route('admin.unidades.store') }}"
            class="form-primary" autocomplete="off">
            @csrf
            @if ($unidade->exists)
                @method('PUT')
            @endif
            <div>
                <label class="label-primary" for="nome">
                    Unidade
                </label>
                <input type="text" name="nome" class="input-primary" value="{{ old('nome', $unidade->nome) }}" required>
                @include('utils.error', ['input' => 'nome'])
            </div>
            @include('admin.utils.form-footer')
        </form>
    </div>
@endsection
