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
                    <input id="date" type="date" wire:model="date" class="form-control">
                    @error('date') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="col-sm-12">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Origen</span>
                    <input id="origin" type="text" wire:model="origin" class="form-control">
                    @error('origin') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="col-sm-12">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Oficina</span>
                    <input id="office_id" type="text" wire:model="office_id" class="form-control">
                    @error('office') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="col-sm-12">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Resumen</span>
                    <input id="abstract" type="text" wire:model="abstract" class="form-control">
                    @error('abstract') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="col-sm-12">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Archivo</span>
                    <input id="filename" type="text" wire:model="filename" class="form-control">
                    @error('filename') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="col-sm-12">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Enlace</span>
                    <input id="link" type="text" wire:model="link" class="form-control">
                    @error('link') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="col-sm-12">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Exposición</span>
                    <input id="display" type="text" wire:model="display" class="form-control">
                    @error('display') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <div class="col-sm-12">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Estado</span>
                    <input id="state" type="text" wire:model="state" class="form-control">
                    @error('state') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>