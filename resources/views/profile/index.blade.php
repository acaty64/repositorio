@extends('adminlte::page')

@section('title', 'Repositorio UCSS')

@section('content_header')
<table class="table table-striped">
    <thead>
        <th>Id</th>
        <th>Nombre</th>
        <th>Email</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @can('profile.edit')
                    <a class="btn btn-sm btn-primary" href="/admin/profile/{{$user->id}}" method='GET'>Editar</a>
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop

@section('content')

@stop