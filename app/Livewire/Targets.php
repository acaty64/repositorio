<?php

namespace App\Livewire;

use App\Models\Target;
use Livewire\Component;
use Livewire\WithPagination;

class Targets extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $document_id;
    public $office_id;
    public $user_id;
    public $task_id;
    public $state;
    public $expiry;
    
    public $status;
    public $target_id;
    public $targets = [];

    public function render()
    {
        return view('livewire.targets', [
            'targets' => Target::all()
            //'targets' => Target::where('document_id', $this->document_id)->paginate(5)
        ]);
    }

    public function mount()
    {
    	$this->status = 'index';
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->target_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->target_id = $id;
    		$this->edit();
    	}
    	if($value == 'destroy')
    	{
    		$this->target_id = $id;
    		$this->destroy();
    	}
    }

    public function create()
    {
		$this->office_id = '';
		$this->user_id = '';
		$this->task_id = '';
		$this->state = '';
		$this->expiry = '';
    }

    public function edit()
    {
    	$target = Target::find($this->target_id);
        $this->office_id = $target->office_id;
		$this->user_id = $target->user_id;
		$this->task_id = $target->task_id;
		$this->state = $target->state;
		$this->expiry = $target->expiry;
    }

    public function destroy()
    {
    	$target = Target::find($this->target_id);
        $this->office_id = $target->office_id;
		$this->user_id = $target->user_id;
		$this->task_id = $target->task_id;
		$this->state = $target->state;
		$this->expiry = $target->expiry;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$target = Target::find($this->tdoc_id);
            $target->office_id = $this->office_id;
            $target->user_id = $this->user_id;
            $target->task_id = $this->task_id;
            $target->state = $this->state;
            $target->expiry = $this->expiry;
			$target->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
	    	Target::create([
				'name' => $this->name ,
                'office_id' => $this->office_id,
                'user_id' => $this->user_id,
                'task_id' => $this->task_id,
                'state' => $this->state,
                'expiry' => $this->expiry,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $target = Target::find($this->target_id);
            $target->delete();
        }

    	$this->status = 'index';
        $this->render();

    }


}
