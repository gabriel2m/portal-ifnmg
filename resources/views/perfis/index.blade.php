@extends('layouts.main')

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('partials.portfolio-header')
        @include('perfis._list')
    </div>
@endsection
