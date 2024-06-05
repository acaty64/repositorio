<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TaskIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status;
    public $task_id;
    public $name;
    public $type;
    public $color;
    public $order;
    public $user_id;

    public function render()
    {
        return view('livewire.task-index', [
            'tasks' => Task::paginate(5)
        ]);
    }

    protected $rules = [
        'name' => 'required',
        'type' => 'required',
    ];

    public function mount()
    {
    	$this->status = 'index';
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->task_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->task_id = $id;
    		$this->edit();
    	}
        if($value == 'destroy')
        {
            $this->task_id = $id;
            $this->destroy();
        }
    }

    public function create()
    {
		$this->name = '';
		$this->type = '';
		$this->color = '';
		$this->order = 0;
		$this->user_id = 0;
    }

    public function edit()
    {
    	$task = Task::find($this->task_id);
		$this->name = $task->name;
		$this->type = $task->type;
		$this->color = $task->color;
		$this->order = $task->order;
		$this->user_id = $task->user_id;
    }
    
    public function destroy()
    {
     	$task = Task::find($this->task_id);
		$this->name = $task->name;
		$this->type = $task->type;
		$this->color = $task->color;
        $this->order = $task->order;
		$this->user_id = $task->user_id;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$task = Task::find($this->task_id);
			$task->name = $this->name ;
			$task->type = $this->type ;
			$task->color = $this->color ;
			$task->order = $this->order ;
			$task->user_id = $this->user_id ;
			$task->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
	    	Task::create([
				'name' => $this->name ,
				'type' => $this->type ,
				'color' => $this->color ,
				'order' => $this->order ,
				'user_id' => $this->user_id ,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $task = Task::find($this->task_id);
            $task->delete();
        }

    	$this->status = 'index';
        $this->render();

    }
}
