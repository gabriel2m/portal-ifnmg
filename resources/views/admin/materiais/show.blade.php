@extends('layouts.admin')

@php
$pageTitle = [$material->nome, 'Materiais'];
@endphp

@section('content')
    @include('admin.utils.content-title', [
        'text' => 'Material',
    ])
    <table class="table-primary mx-auto">
        <tbody>
            @foreach ([
            'nome' => 'Nome',
            'catmat' => 'CATMAT',
            'descricao' => 'Descrição',
            'unidade_label' => 'Unidade',
        ]
        as $attr => $label)
                <tr>
                    <td class="font-bold">
                        {{ $label }}
                    </td>
                    <td>
                        {{ $material->$attr }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mx-auto w-fit mt-3">
        @include('utils.back-link', ['link' => route('admin.materiais.index')])
    </div>
@endsection
