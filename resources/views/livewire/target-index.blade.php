<div>
    @if( $status == 'index')
        <div class="row">
            <div class="col">
                <span class="float-left">
                    <h1>Lista de Destinos</h1>
                </span>
                <span class="float-right">
                    @can('admin.target.create')
                        <button class="btn-success btn-lg float-right" wire:click="setStatus('create')">Agregar</button>
                    @endcan
                </span>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Id</th>
                    <th>Oficina</th>
                    <th>Persona</th>
                    <th>Tarea</th>
                    <th>Estado</th>
                    <th>Vencimiento</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($targets as $target)
                    <tr>
                        <td>{{$target->id}}</td>
                        <td>{{$target->office_id}}</td>
                        <td>{{$target->user_id}}</td>
                        <td>{{$target->task_id}}</td>
                        <td>{{$target->state}}</td>
                        <td>{{\Carbon\Carbon::createFromTimestamp(strtotime($target->expiry))->format('d-m-Y')}}</td>
                        <td>
                            @can('admin.target.edit')
                                <a class='btn btn-primary me-md-2' wire:click="setStatus('edit', {{ $target->id }})">Editar</a>
                            @endcan
                            @can('admin.target.destroy')
                                <a class='btn btn-danger' wire:click="setStatus('destroy', {{ $target->id }})">Borrar</a>
                            @endcan
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    @if( $status == 'create' || $status == 'edit')
        <div class="container">
            <div class="card-header">
                @if( $status == 'edit' )
                    <div>
                        <h1>Edición de Destino Id: {{ $target_id }}</h1>
                        <h2>Documento Id: {{ $document_id }}</h2>
                    </div>
                @endif
                @if( $status == 'create' )
                    <div>
                        <h1>Nuevo Destino</h1>
                        <h2>Documento Id: {{ $document_id }}</h2>
                    </div>
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
                            <span class="input-group-text" id="basic-addon1">Oficina</span>
                            <input type="integer" wire:model="office_id" class="form-control" >
                            @error('office_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Persona</span>
                            <input type="integer" wire:model="user_id" class="form-control" >
                            @error('user_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tarea</span>
                            <input type="integer" wire:model="task_id" class="form-control" >
                            @error('task_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Estado</span>
                            <input type="text" wire:model="state" class="form-control" >
                            @error('state') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Vencimiento</span>
                            <input type="date" wire:model="expiry" class="form-control" >
                            @error('expiry') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if( $status == 'destroy' )
        <div class="container">
            <div class="card-header">
                <h1>Destino a Eliminar Id: {{ $target_id }}</h1>
                <button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
                <button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Oficina</span>
                            <input readonly type="integer" wire:model="office_id" class="form-control" >
                            @error('office_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Persona</span>
                            <input readonly type="integer" wire:model="user_id" class="form-control" >
                            @error('user_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tarea</span>
                            <input readonly type="integer" wire:model="task_id" class="form-control" >
                            @error('task_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Estado</span>
                            <input readonly type="text" wire:model="state" class="form-control" >
                            @error('state') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Vencimiento</span>
                            <input readonly type="date" wire:model="expiry" class="form-control" >
                            @error('expiry') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>