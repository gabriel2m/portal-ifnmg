@extends('layouts.error')

@php($pageTitle[] = __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized'))
