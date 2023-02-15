@extends('layouts.main')

@php($showBanner = false)

@section('main-content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.content-title')
        @yield('auth-content')
    </div>
@endsection
