@extends('layouts.main')

@php
$pageTitle = 'Novo Perfil';
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('partials.content-title')
        @include('perfis._save')
    </div>
@endsection
