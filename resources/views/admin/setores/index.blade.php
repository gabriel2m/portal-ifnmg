@extends('layouts.admin')

@php
$title[] = 'Setores';
@endphp

@section('main-content')
    @include('admin.utils.content-title')
    @include('admin.utils.resource-table', [
        'resource_name' => 'admin.setores',
        'models' => $setores,
        'attrs' => ['nome' => 'Setor'],
    ])
@endsection
