<div>
    @if( $status == 'index')
        <div class="row">
            <div class="col">
                <span class="float-left">
                    <h1>Lista de Roles</h1>
                </span>
                <span class="float-right">
                    @can('admin.role.create')
                    <button class="btn-success btn-lg float-right" wire:click="setStatus('create')">Agregar</button>
                    @endcan
                </span>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Id</th>
                    <th>Descripción</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>
                            @can('admin.role.edit')
                                <a class='btn btn-primary me-md-2' wire:click="setStatus('edit', {{ $role->id }})">Editar</a>
                            @endcan
                            @can('admin.role.destroy')
                                <a class='btn btn-danger' wire:click="setStatus('destroy', {{ $role->id }})">Borrar</a>
                            @endcan
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3">{{ $roles->links() }}</div>
        </div>
    @endif
    @if( $status == 'create' || $status == 'edit')
        <div class="container">
            <div class="card-header">
                @if( $status == 'edit' )
                    <div>
                        <h1>Edición de Rol Id: {{ $role_id }}</h1>
                    </div>
                @endif
                @if( $status == 'create' )
                    <h1>Nuevo Rol</h1>
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
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Descripción</span>
                            <input type="text" wire:model="name" class="form-control">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                @if( $status == 'create' )
                    <label for="selectRole" class="form-label">Seleccione el rol a copiar sus permisos: </label>
                    <select id="selectRole" wire:model.change="copy_role" class="form-select form-select-lg ml-3">
                        @foreach($this->copy_roles as $item_rol)
                            <option value={{ $item_rol->id }}>{{ $item_rol->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="input-group-text">Asignación de Permisos - Marque los permisos asignados a este rol.</div>
            <div class="input-group-text">
                <div class="container">
                    <div class="row">
                        Permisos asignados:  
                    </div>
                    <div class="row">
                        @foreach($this->checks as $item_check)
                            <span class="badge text-bg-primary">{{ $item_check['description'] }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($this->permissions as $item)
                        <label class="col-md-6">
                            <input wire:model="checkPermissions" value="{{ $item['id'] }}" type="checkbox" wire:click="$refresh">
                            {{ $item['description'] }}
                        </label>
                    @endforeach
                </div>
            </div>
            <Seleccionado: {{ var_export($this->checkPermissions) }}>
        </div>
    @endif
    @if( $status == 'destroy' )
        <div class="container">
            <div class="card-header">
                <h1>Rol a Eliminar Id: {{ $role_id }}</h1>
                <button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
                <button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <div class="col-sm-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Descripción</span>
                                <input readonly type="name" wire:model="name" class="form-control" >
                                @error('name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
