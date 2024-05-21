<div>
    @if( $status == 'index')
        <div class="row">
            <div class="col">
                <span class="float-left">
                    <h1>Lista de Tipo de Documentos</h1>
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
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($tdocs as $tdoc)
                    <tr>
                        <td>{{$tdoc->id}}</td>
                        <td>{{$tdoc->name}}</td>
                        <td>
                            @can('admin.tdoc.edit')
                                <a class='btn btn-primary me-md-2' wire:click="setStatus('edit', {{ $tdoc->id }})">Editar</a>
                            @endcan
                            @can('admin.tdoc.destroy')
                                <a class='btn btn-danger' wire:click="setStatus('destroy', {{ $tdoc->id }})">Borrar</a>
                            @endcan
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3">{{ $tdocs->links() }}</div>
        </div>
    @endif
    @if( $status == 'create' || $status == 'edit')
        <div class="container">
            <div class="card-header">
                @if( $status == 'edit' )
                    <div>
                        <h1>Edición de Tipo de Documento Id: {{ $tdoc_id }}</h1>
                    </div>
                @endif
                @if( $status == 'create' )
                    <h1>Nuevo Tipo de Documento</h1>
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
            </div>
        </div>
    @endif
    @if( $status == 'destroy' )
        <div class="container">
            <div class="card-header">
                <h1>Tipo de documento a Eliminar Id: {{ $tdoc_id }}</h1>
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
                </div>
            </div>
        </div>
    @endif
</div>