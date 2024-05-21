<div>
    @if( $status == 'index')
        <div class="row">
            <div class="col">
                <span class="float-left">
                    <h1>Lista de Oficinas</h1>
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
                    <th>Nombre</th>
                    <th>Abreviatura</th>
                    <th>Nivel</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($offices as $office)
                    <tr>
                        <td>{{$office->id}}</td>
                        <td>{{$office->name}}</td>
                        <td>{{$office->abbrev}}</td>
                        <td>{{$office->level}}</td>
                        <td>
                            @can('admin.office.edit')
                                <a class='btn btn-primary me-md-2' wire:click="setStatus('edit', {{ $office->id }})">Editar</a>
                            @endcan
                            @can('admin.office.destroy')
                                <a class='btn btn-danger' wire:click="setStatus('destroy', {{ $office->id }})">Borrar</a>
                            @endcan
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3">{{ $offices->links() }}</div>
        </div>
    @endif
    @if( $status == 'create' || $status == 'edit')
        <div class="container">
            <div class="card-header">
                @if( $status == 'edit' )
                    <div>
                        <h1>Edición de Oficina Id: {{ $office_id }}</h1>
                    </div>
                @endif
                @if( $status == 'create' )
                    <h1>Nueva Oficina</h1>
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
                            <span class="input-group-text" id="basic-addon1">Nombre</span>
                            <input type="name" wire:model="name" class="form-control" >
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Abreviatura</span>
                            <input type="email" wire:model="abbrev" class="form-control" >
                            @error('abbrev') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nivel</span>
                            <input type="text" class="form-control" wire:model="level">
                            @error('level') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if( $status == 'destroy' )
        <div class="container">
            <div class="card-header">
                <h1>Oficina a Eliminar Id: {{ $office_id }}</h1>
                <button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
                <button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <div class="col-sm-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Nombre</span>
                                <input readonly type="name" wire:model="name" class="form-control" >
                                @error('name') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Abreviatura</span>
                            <input readonly type="email" wire:model="abbrev" class="form-control" >
                            @error('abbrev') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Nivel</span>
                            <input readonly type="text" class="form-control" wire:model="level">
                            @error('level') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
