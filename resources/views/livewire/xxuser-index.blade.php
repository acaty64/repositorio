<div>
    {{-- The whole world belongs to you. --}}
    <h1>Lista de Usuarios</h1>
    
    <div>
        <table class="table table-striped table-hover">
            <thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>e-mail</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <a class='btn btn-primary me-md-2' href="{{route('admin.profile.edit', compact('user'))}}">Editar</a>
                        <a class='btn btn-danger' href="">Borrar</a>
                    </td>
                </tr> 
                @endforeach
            </tbody>
        </table>
        
        {{ $users->links() }}
    </div>
</div>
