@extends('layouts.error')

@php($pageTitle[] = __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))
