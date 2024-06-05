<div>
    @if( $status == 'index')
        <div class="row">
            <div class="col">
                <span class="float-left">
                    <h1>Lista de Tareas</h1>
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
                    <th>Tarea</th>
                    <th>Tipo</th>
                    <th>Color</th>
                    <th>Orden</th>
                    <th>Usuario</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                    <tr>
                        <td>{{$task->id}}</td>
                        <td>{{$task->name}}</td>
                        <td>{{$task->type}}</td>
                        <td>{{$task->color}}</td>
                        <td>{{$task->order}}</td>
                        <td>{{$task->user_id}}</td>
                        <td>
                            @can('admin.task.edit')
                                <a class='btn btn-primary me-md-2' wire:click="setStatus('edit', {{ $task->id }})">Editar</a>
                            @endcan
                            @can('admin.task.destroy')
                                <a class='btn btn-danger' wire:click="setStatus('destroy', {{ $task->id }})">Borrar</a>
                            @endcan
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3">{{ $tasks->links() }}</div>
        </div>
    @endif
    @if( $status == 'create' || $status == 'edit')
        <div class="container">
            <div class="card-header">
                @if( $status == 'edit' )
                    <div>
                        <h1>Edición de Tarea Id: {{ $task_id }}</h1>
                    </div>
                @endif
                @if( $status == 'create' )
                    <h1>Nueva Tarea</h1>
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
                            <span class="input-group-text" id="basic-addon1">Tarea</span>
                            <input type="name" wire:model="name" class="form-control" >
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tipo</span>
                            <input type="text" wire:model="type" class="form-control" >
                            @error('type') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Color</span>
                            <input type="text" class="form-control" wire:model="color">
                            @error('color') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Orden</span>
                            <input type="integer" class="form-control" wire:model="order">
                            @error('order') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Usuario</span>
                            <input type="integer" class="form-control" wire:model="user_id">
                            @error('user_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if( $status == 'destroy' )
        <div class="container">
            <div class="card-header">
                <h1>Tarea a Eliminar Id: {{ $task_id }}</h1>
                <button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
                <button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="col-sm-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tarea</span>
                            <input readonly type="name" wire:model="name" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Tipo</span>
                            <input readonly type="text" wire:model="type" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Color</span>
                            <input readonly type="text" class="form-control" wire:model="color">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Orden</span>
                            <input readonly type="integer" class="form-control" wire:model="order">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Usuario</span>
                            <input readonly type="integer" class="form-control" wire:model="user_id">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
