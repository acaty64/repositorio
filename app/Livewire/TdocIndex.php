<?php

namespace App\Livewire;

use App\Models\Tdoc;
use Livewire\Component;
use Livewire\WithPagination;

class TdocIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status;
    public $tdoc_id;
    public $name;

    public function render()
    {
        return view('livewire.tdoc-index', [
            'tdocs' => Tdoc::paginate(5)
        ]);
    }

    protected $rules = [
        'name' => 'required',
    ];

    public function mount()
    {
    	$this->status = 'index';
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->tdoc_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->tdoc_id = $id;
    		$this->edit();
    	}
    	if($value == 'destroy')
    	{
    		$this->tdoc_id = $id;
    		$this->destroy();
    	}

    }

    public function create()
    {
		$this->name = '';
    }

    public function edit()
    {
    	$tdoc = Tdoc::find($this->tdoc_id);
		$this->name = $tdoc->name;
    }

    public function destroy()
    {
     	$tdoc = Tdoc::find($this->tdoc_id);
		$this->name = $tdoc->name;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$tdoc = Tdoc::find($this->tdoc_id);
			$tdoc->name = $this->name ;
			$tdoc->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
	    	Tdoc::create([
				'name' => $this->name ,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $tdoc = Tdoc::find($this->tdoc_id);
            $tdoc->delete();
        }

    	$this->status = 'index';
        $this->render();

    }
}

