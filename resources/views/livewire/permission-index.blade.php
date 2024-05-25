<div>
    @if( $status == 'index')
        <div class="row">
            <div class="col">
                <span class="float-left">
                    <h1>Lista de Permisos</h1>
                </span>
                <span class="float-right">
                    @can('admin.tdoc.create')
                    <button class="btn-success btn-lg float-right" wire:click="setStatus('create')">Agregar</button>
                    @endcan
                </span>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Id</th>
                    <th>Ruta de Permiso</th>
                    <th>Guard Name</th>
                    <th>Descripción</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                    <tr>
                        <td>{{$permission->id}}</td>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->guard_name}}</td>
                        <td>{{$permission->description}}</td>
                        <td>
                            @can('admin.permission.edit')
                                <a class='btn btn-primary me-md-2' wire:click="setStatus('edit', {{ $permission->id }})">Editar</a>
                            @endcan
                            @can('admin.permission.destroy')
                                <a class='btn btn-danger' wire:click="setStatus('destroy', {{ $permission->id }})">Borrar</a>
                            @endcan
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3">{{ $permissions->links() }}</div>
        </div>
    @endif
    @if( $status == 'create' || $status == 'edit')
        <div class="container">
            <div class="card-header">
                @if( $status == 'edit' )
                    <div>
                        <h1>Edición de Permiso Id: {{ $permission_id }}</h1>
                    </div>
                @endif
                @if( $status == 'create' )
                    <h1>Nuevo Permiso</h1>
                @endif
                <div class="row">
                    <div class="col-sm-3">
                        <button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn-danger btn-lg" wire:click="save">Grabar</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Ruta de Permiso</span>
                            <input type="text" wire:model="name" class="form-control" >
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Guard Name</span>
                            <input type="text" wire:model="guard_name" class="form-control" >
                            @error('guard_name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Descripción</span>
                            <input type="text" class="form-control" wire:model="description">
                            @error('description') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if( $status == 'destroy' )
        <div class="container">
            <div class="card-header">
                <h1>Permiso a Eliminar Id: {{ $permission_id }}</h1>
                <button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
                <button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <div class="col-sm-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Ruta de Permiso</span>
                                <input readonly type="name" wire:model="name" class="form-control" >
                                @error('name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Guard Name</span>
                            <input readonly type="text" wire:model="guard_name" class="form-control" >
                            @error('guard_name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Descripción</span>
                            <input readonly type="text" class="form-control" wire:model="description">
                            @error('description') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
