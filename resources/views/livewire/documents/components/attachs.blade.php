<div class="container">
    <div>        
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        {{-- <div class="alert alert-success">
            upload_progress: {{ $upload_progress }}
        </div> --}}
    </div>
    {{-- <h1>views/livewire/documents/components/attachs.blade.php</h1> --}}
    <div class="row">
        <div class="card">
            <div class="alert alert-primary" style="text-align: center">
                    <div x-data="drop_file_component()">
                        <div 
                            x-bind:class="dropingFile ? 'bg-gray-400 border-gray-500' : 'border-gray-500 bg-gray-200'"
                            x-on:drop="dropingFile = false"
                            x-on:drop.prevent="handleFileDrop($event)"
                            x-on:dragover.prevent="dropingFile = true"
                            x-on:dragleave.prevent="dropingFile = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="currentColor" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                                <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                            </svg>
                            <h6>Arrastre y suelte aquí el archivo seleccionado</h6>
                        <div class="progress mt-0">
                            <div class="progress-bar" role="progress-bar" :style="{width:upload_progress+'%'}" aria-valuemin="0" aria-valuemax="100" x-text="upload_progress+'%'"></div>
                            {{-- <div class="progress-bar" role="progress-bar" aria-valuemin="0" aria-valuemax="100" x-text="'%'"></div> --}}
                        </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="card-body" style="text-align: center">
            <div class="alert alert-success">
                Archivos seleccionados <span class="badge text-bg-secondary">{{ $q_files }}</span>
            </div>
        </div>
        @if(!@empty($uploaded_files))
            @foreach ($uploaded_files as $key => $uploaded_file)
                <ul class="list-group">
                    <li wire:key="({{ $loop->index }})" class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{ $loop->index + 1 }} - {{ $uploaded_file[0] }}</div>
                        </div>
                        <div class="text-end"><button wire:click="remove({{$key}})" type="button" class="btn btn-sm btn-danger">X</button></div>
                    </li>
                </ul>
            @endforeach
        @endempty
    </div>
    @script
    <script>
        Alpine.data('drop_file_component', () => {
            upload_progress= 0;
            return {
                dropingFile: false,

                handleFileDrop(e) {
                    if (event.dataTransfer.files.length > 0) {
                        const files = e.dataTransfer.files;
                        @this.uploadMultiple('files', files,
                            () => {}, () => {}, (event) => {
                                upload_progress=event.detail.progress
                            }
                        )
                    }
                }
            };
        });
    </script>
    @endscript
</div>