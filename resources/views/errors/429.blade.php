@extends('layouts.error')

@php($pageTitle[] = __('Too Many Requests'))
@section('code', '429')
@section('message', __('Too Many Requests'))
