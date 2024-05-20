<?php

namespace App\Livewire;

use App\Models\Office;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeIndex extends Component
{
    use WithPagination;
    //protected $paginationTheme = 'bootstrap';

    public $status;
    public $office_id;
    public $name;
    public $abbrev;
    public $level;

    public function render()
    {
        return view('livewire.office-index', [
            'offices' => Office::paginate(5)
        ]);
    }

    protected $rules = [
        'name' => 'required',
        'abbrev' => 'required',
        'level' => 'required',
    ];

    public function mount()
    {
    	$this->status = 'index';
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->office_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->office_id = $id;
    		$this->edit();
    	}
        /*
        if($value == 'destroy')
        {
            $this->office_id = $id;
            $this->destroy();
        }
        */
    }

    public function create()
    {
		$this->name = '';
		$this->abbrev = '';
		$this->level = '';
    }

    public function edit()
    {
    	$office = Office::find($this->office_id);
		$this->name = $office->name;
		$this->abbrev = $office->abbrev;
		$this->level = $office->level;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$office = Office::find($this->office_id);
			$office->name = $this->name ;
			$office->abbrev = $this->abbrev ;
			$office->level = $this->level ;
			$office->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
	    	Office::create([
				'name' => $this->name ,
				'abbrev' => $this->abbrev ,
				'level' => $this->level ,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $office = Office::find($this->office_id);
            $office->delete();
        }

    	$this->status = 'index';
        $this->render();

    }
}
