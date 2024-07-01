<div>
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    @if( $status == 'index')
        @livewire('documents.components.index')
    @endif
    @if( $status == 'create' || $status == 'edit')
        @livewire('documents.components.edit')
        @livewire('documents.components.attachs')
        @livewire('documents.components.targets')
    @endif
    @if( $status == 'destroy')
        @livewire('documents.components.destroy')
    @endif
</div>