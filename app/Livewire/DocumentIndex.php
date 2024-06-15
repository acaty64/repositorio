<?php

namespace App\Livewire;

use App\Models\Attach;
use App\Models\Document;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class DocumentIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $id;
    public $date;
    public $origin;
    public $office_id;
    public $abstract;
    public $filename;
    public $link;
    public $display;
    public $document_id;
    public $state;
    public $attach;
    
    public $status;

    public function render()
    {
        return view('livewire.document-index', [
            'documents' => Document::orderBy('id', 'DESC')->paginate(5)
        ]);
    }

    protected $rules = [
        'date' => 'required',
        'office_id' => 'required',
        'filename' => 'required',
        'link' => 'required',
        'display' => 'required',
        'state' => 'required',
    ];

    public function mount()
    {
    	$this->status = 'index';
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->document_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->document_id = $id;
    		$this->edit();
    	}
        if($value == 'destroy')
        {
            $this->document_id = $id;
            $this->destroy();
        }
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

    public function destroy()
    {
    	$document = Document::find($this->document_id);
		$this->date = Carbon::createFromTimestamp(strtotime($document->date))->format('Y-m-d');
		$this->origin = $document->origin;
		$this->office_id = $document->office_id;
		$this->abstract = $document->abstract;
		$this->state = $document->state;
		$this->attach = $document->attach;
		/*
		$this->filename = $document->filename;
		$this->link = $document->link;
		$this->display = $document->display;
		*/
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

			$attach = $document->attach ;
$this->attach= $attach ;
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
            $document->delete();
			session()->flash('message', 'Registro eliminado exitosamente. Id: ' . $document->id);
        
		}

    	$this->status = 'index';
        $this->render();

    }

}
