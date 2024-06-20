@extends('adminlte::page')

@section('title', 'Repositorio UCSS')

@section('content_header')
<h1>TESTING LIVEWIRE CON ALPINE</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-9">
            @livewire('tests-index')
        </div>
    </div>
@stop