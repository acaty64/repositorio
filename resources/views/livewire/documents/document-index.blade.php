<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    @livewire('documents.components.attachs')
    @if($uploaded_files)
        @foreach ($uploaded_files as $item)
            <li>$item[1]</li>   
        @endforeach
    @endif
</div>