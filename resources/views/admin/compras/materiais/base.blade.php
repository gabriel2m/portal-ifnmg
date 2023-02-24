@extends('admin.compras.base')

@php
    array_push($title, 'Materiais', $material_compra->compra->ano);
@endphp

@prepend('styles')
@endprepend

@prepend('scripts')
@endprepend
