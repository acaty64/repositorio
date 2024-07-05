@extends('adminlte::page')

@section('title', 'Repositorio UCSS')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    @livewire('documents.document-index')
@stop