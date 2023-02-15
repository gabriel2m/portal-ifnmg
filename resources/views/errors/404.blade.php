@extends('layouts.error')

@php($title[] = __('Not Found'))
@section('code', '404')
@section('message', __($exception->getMessage() ?: 'Not Found'))
