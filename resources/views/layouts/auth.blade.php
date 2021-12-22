@extends('layouts.main')

@php
$showBanner = false;
@endphp

@section('content')
    <div class="mx-auto max-w-screen-lg">
        @include('utils.content-title')
        @yield('auth-content')
    </div>
@endsection
