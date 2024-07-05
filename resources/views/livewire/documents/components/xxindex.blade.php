<div class="container">
    <div class="row">
        <div class="col">
            <span class="float-left">
                <h1>Lista de Documentos Status: {{ $status }}</h1>
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
                        <a id="btnEdit{{ $document->id }}" class='btn btn-primary me-md-2' wire:click="setStatus('edit', {{ $document->id }})">Editar</a>
                        @endcan
                        @can('admin.document.destroy')
                        <a id="btnDestroy{{ $document->id }}" class='btn btn-danger' wire:click="setStatus('destroy', {{ $document->id }})">Borrar</a>
                        @endcan
                    </td>
                </tr> 
                @endforeach
            </tbody>
        </table>
        <div class="px-6 py-3">{{ $documents->links() }}</div>
    </div>
</div>