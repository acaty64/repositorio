<div class="container">
    <div>{{ $message }}</div>
    <h1>views/livewire/tests/tests2-index.blade.php</h1>
    <div x-data="dragDrop()" class="mb-0">
        <div class="card" x-on:dragover.prevent="dragover" x-on:dragleave.prevent="dragleave" x-on:drop.prevent="drop($event)">
            <div class="card-body">
                <div style="text-align: center">
                    <h4>Arrastre y suelte aquí el archivo seleccionado</h4>
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" fill="currentColor" class="bi bi-cloud-arrow-up" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708z"/>
                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>
                    </svg>
                </div>
                <input @change="uploadSelected" type="file" class="form-control" multiple>
                @error('files.*')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="progress mt-0">
                <div class="progress-bar" role="progress-bar" :style="{width:uploadProgress+'%'}" aria-valuemin="0" aria-valuemax="100" x-text="uploadProgress+'%'"></div>
            </div>
        </div>
        @if(!@empty($attachs))
            @foreach ($attachs as $attach)
                <ul class="list-group">
                    <li wire:key="({{ $loop->index }})" class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            {{-- <div class="fw-bold">{{ $attach->getClientOriginalName() }}</div> --}}
                            <div class="fw-bold">{{ $loop->index }}</div>
                        </div>
                        <svg wire:click="remove({{ $loop->index }})" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                            <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                        </svg>
                    </li>
                </ul>
            @endforeach
        <button wire:click="uploadFiles" class="btn btn-success">Upload Files {{ count($attachs) }}</button>
        @endempty

    </div>
    <script>
        function dragDrop() {
            return {
                uploadProgress:0,
                dragover(){
                    // alert('dragover');
                },
                dragleave(){
                    // alert('dragleave');
                },
                uploadSelected(e){
                    // alert('drop similar');
                    if(event.target.files.length>0){
                        const files=event.target.files
                        this.uploadFiles(files)
                    }
                },
                drop(e){
                    // alert('uploadSelected similar');
                    if(event.dataTransfer.files.length>0){
                        const files=e.dataTransfer.files
                        this.uploadFiles(files)
                    }
                },
                uploadFiles(files){
                    @this.uploadMultiple('files',files,
                        (success)=>{
                            
                        },
                        (error)=>{
    
                        },
                        (event)=>{                            
                            this.uploadProgress=event.detail.progress
                        }
                    )
                }
                
            }
        }
    </script>
</div>