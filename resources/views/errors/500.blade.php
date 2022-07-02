@extends('layouts.error')

@php($pageTitle[] = __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
