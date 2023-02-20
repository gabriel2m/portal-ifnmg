@extends('layouts.base')

@php
    $title[] = 'Área Administrativa';
    $body_attrs = ['class' => 'hold-transition sidebar-mini'];
@endphp

@prepend('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
@endprepend

@section('content')
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-external-link-alt"></i>
                        Portal
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-3 bg-color-3">
            <!-- Brand Logo -->
            <a href="{{ route('admin.home') }}" class="brand-link">
                <img src="{{ asset('img/ifnmg-logo.png') }}" alt="Logo" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-semibold">SINPRO</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @foreach ([
            [
                'link' => route('admin.materiais.index'),
                'label' => 'Materiais',
            ],
        ] as $item)
                            <li class="nav-item">
                                <a href="{{ $item['link'] }}" @class([
                                    'nav-link',
                                    'active' => $item['link'] == ($active_link ?? false),
                                ])>
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>
                                        {{ $item['label'] }}
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">{{ $title[0] }}</h1>
                        </div>
                        <!-- /.col -->
                        @isset($breadcrumb)
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    @foreach ($breadcrumb as $item)
                                        <li @class(['breadcrumb-item', 'active' => $item['active'] ?? false])>
                                            <a href="{{ $item['link'] }}">
                                                {{ $item['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        @endisset
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>2023 <a href="https://ifnmg.edu.br">IFNMG</a>.</strong>
        </footer>
    </div>
@overwrite

@prepend('scripts')
    <script src="{{ mix('js/admin.js') }}"></script>
@endprepend
