@extends('layouts.admin')

@php
$title[] = 'Unidades';
@endphp

@section('main-content')
    @include('admin.utils.content-title')
    @include('admin.utils.resource-table', [
        'resource_name' => 'admin.unidades',
        'models' => $unidades,
        'attrs' => ['nome' => 'Unidade'],
    ])
@endsection
