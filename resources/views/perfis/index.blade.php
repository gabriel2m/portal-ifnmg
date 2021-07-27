@extends('layouts.main')

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('partials.content-title')
        @include('perfis._list')
    </div>
@endsection
