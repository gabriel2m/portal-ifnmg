@extends('layouts.main')

@php
$pageTitle = [$perfil->nome, 'Editar'];
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('partials.content-title', ['contentTitle' => 'Editar Perfil'])
        @include('perfis._guard_form')
    </div>
@endsection
