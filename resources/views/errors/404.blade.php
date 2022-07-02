@extends('layouts.error')

@php($pageTitle[] = __('Not Found'))
@section('code', '404')
@section('message', __($exception->getMessage() ?: 'Not Found'))
