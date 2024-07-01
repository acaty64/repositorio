<div class="container">

    <h1>
        Componente destroy
    </h1>

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