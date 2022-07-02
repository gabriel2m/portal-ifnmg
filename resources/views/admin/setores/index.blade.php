@extends('layouts.admin')

@php
$pageTitle[] = 'Setores';
@endphp

@section('content')
    @include('admin.utils.content-title')
    @include('admin.utils.resource-table', [
        'resource_name' => 'admin.setores',
        'models' => $setores,
        'attrs' => ['nome' => 'Setor'],
    ])
@endsection
