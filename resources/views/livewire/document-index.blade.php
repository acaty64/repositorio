<div>
    @if( $status == 'index')
        <div class="row">
            <div class="col">
                <span class="float-left">
                    <h1>Lista de Documentos</h1>
                </span>
                <span class="float-right">
                    @can('admin.document.create')
                    <button id= "btn-create" class="btn-success btn-lg float-right" wire:click="setStatus('create')">Agregar</button>
                    @endcan
                </span>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped table-hover">
                <thead>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Origen</th>
                    <th>Oficina de Origen</th>
                    <th>Resumen</th>
                    <th>Documento</th>
                    <th>Enlace</th>
                    <th>Exposición</th>
                    <th>Estado</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                    <tr>
                        <td>{{$document->id}}</td>
                        <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($document->date))->format('d-m-Y') }}</td>
                        <td>{{$document->origin}}</td>
                        <td>{{$document->office_id}}</td>
                        <td>{{$document->abstract}}</td>
                        <td>{{$document->filename}}</td>
                        <td>{{$document->link}}</td>
                        <td>{{$document->display}}</td>
                        <td>{{$document->state}}</td>
                        <td>
                            @can('admin.document.edit')
                            <a class='btn btn-primary me-md-2' wire:click="setStatus('edit', {{ $document->id }})">Editar</a>
                            @endcan
                            @can('admin.document.destroy')
                            <a class='btn btn-danger' wire:click="setStatus('destroy', {{ $document->id }})">Borrar</a>
                            @endcan
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3">{{ $documents->links() }}</div>
        </div>
    @endif
    @if( $status == 'create' || $status == 'edit')
        <div class="container">
            <div class="card-header">
                @if( $status == 'edit' )
                    <div><h1>Edición de Documento Id: {{ $document_id }}</h1></div>
                @endif
                @if( $status == 'create' )
                    <h1>Nuevo Documento</h1>
                @endif
                <div class="row">
                    <div class="col-sm-3">
                        <button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
                    </div>
                    <div class="col-sm-3">
                        <button id="btn-save" class="btn-danger btn-lg" wire:click="save">Grabar</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Fecha de Documento</span>
                            <input type="date" wire:model="date" class="form-control">
                            @error('date') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Origen</span>
                            <input type="text" wire:model="origin" class="form-control">
                            @error('origin') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Oficina</span>
                            <input type="text" wire:model="office_id" class="form-control">
                            @error('office') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Resumen</span>
                            <input type="text" wire:model="abstract" class="form-control">
                            @error('abstract') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Archivo</span>
                            <input type="text" wire:model="filename" class="form-control">
                            @error('filename') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Enlace</span>
                            <input type="text" wire:model="link" class="form-control">
                            @error('link') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Exposición</span>
                            <input type="text" wire:model="display" class="form-control">
                            @error('display') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Estado</span>
                            <input type="text" wire:model="state" class="form-control">
                            @error('state') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group-text">Destino</div>
            <span>ToDo: Destino</span>
            @livewire('targetIndex', ['document_id' => $document_id, 'status' => $status])
        </div>
    @endif
    @if( $status == 'destroy' )
        <div class="container">
            <div class="card-header">
                <h1>Documento a Eliminar Id: {{ $document_id }}</h1>
                <button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
                <button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
            </div>
            <div class="card-body">
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Fecha de Documento</span>
                            <input readonly type="text" wire:model="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Origen</span>
                            <input readonly type="text" wire:model="origin" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Oficina</span>
                            <input readonly type="text" wire:model="office_id" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Resumen</span>
                            <input readonly type="text" wire:model="abstract" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Archivo</span>
                            <input readonly type="text" wire:model="filename" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Enlace</span>
                            <input readonly type="text" wire:model="link" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Exposición</span>
                            <input readonly type="text" wire:model="display" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <div class="col-sm-12">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Estado</span>
                            <input readonly type="text" wire:model="state" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
