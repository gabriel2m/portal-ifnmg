@extends('layouts.main')

@php
$pageTitle[] = $contentTitle = 'Novo Perfil';
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.content-title')
        @include('perfis._guard_form')
    </div>
@endsection
