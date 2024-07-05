<?php

namespace App\Livewire\Documents\Components;

use App\Models\Attach;
use App\Models\Document;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status, $document_id;

    public $id, $date, $origin, $office_id, $abstract, $filename, $link, $display, $state, $attach;
    public function render()
    {
        return view('livewire.documents.components.edit');
    }

    protected $rules = [
        'date' => 'required',
        'office_id' => 'required',
        'state' => 'required',
        'filename' => 'required',
        'link' => 'required',
        'display' => 'required',
    ];

    #[On('status')]
    public function status($status)
    {
        $this->status = $status;
    }

    #[On('document_id')]
    public function document_id($id)
    {
        $this->document_id = $id;
    }

    public function setStatus($status, $document_id=null)
    {
        
        $this->status = $status;
        $this->document_id = $document_id;

        $this->dispatch('status', $status);
    }

    public function create()
    {
		$this->date = Carbon::now()->format('d-m-Y');
		$this->office_id = 0;
		$this->filename = '';
		$this->abstract = '';
		$this->link = '';
		$this->display = '';
		$this->state = 'pendiente';
    }    

    public function edit()
    {
    	$document = Document::find($this->document_id);
		$this->id = $document->id;
		$this->date = Carbon::createFromTimestamp(strtotime($document->date))->format('Y-m-d');
		$this->origin = $document->origin;
		$this->office_id = $document->office_id;
		$this->abstract = $document->abstract;
		$this->state = $document->state;
		$this->attach = $document->attach;
		$this->filename = $document->attach[0]->filename;
		$this->link = $document->attach[0]->link;
		$this->display = $document->attach[0]->display;

	}

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$document = Document::find($this->document_id);
			$document->date = $this->date ;
			$document->origin = $this->origin ;
			$document->office_id = $this->office_id ;
			$document->abstract = $this->abstract ;
			$document->state = $this->state ;
			$document->save();

			$attach = $document->attach[0] ;
			$attach->attachable_id = $document->id ;
			$attach->attachable_type = Document::class ;
			$attach->filename = $this->filename ;
			$attach->link = $this->link ;
			$attach->display = $this->display ;
			$attach->save();
			
			session()->flash('message', 'Registro actualizado exitosamente. Id: ' . $document->id);
    	
		}elseif( $this->status == 'create'){
            
			$this->validate();

	    	$document = Document::create([
				'date' => $this->date ,
				'origin' => $this->origin ,
				'office_id' => $this->office_id ,
				'abstract' => $this->abstract ,
				'state' => $this->state ,
				]);
			
			Attach::create([
				'attachable_id' => $document->id ,
				'attachable_type' => Document::class ,
				'filename' => $this->filename ,
				'link' => $this->link ,
				'display' => $this->display ,
			]) ;

			session()->flash('message', 'Registro creado exitosamente.');

    	}elseif( $this->status == 'destroy'){
            
			$document = Document::find($this->document_id);
			$attaches = $document->attach;
			foreach($attaches as $attach){
				$attach->delete();
			};
            $document->delete();
			session()->flash('message', 'Registro eliminado exitosamente. Id: ' . $document->id);
        
		}

    	$this->status = 'index';
        $this->render();

    }


}