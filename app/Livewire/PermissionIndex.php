<?php

namespace App\Livewire;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;
use Livewire\WithPagination;

class PermissionIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status;
    public $permission_id;
    public $name;
    public $guard_name;
    public $description;
    public $roles;

    public function render()
    {
        return view('livewire.permission-index', [
            'permissions' => Permission::paginate(5)
        ]);
    }

    protected $rules = [
        'name' => 'required',
        'guard_name' => 'required',
        'description' => 'required',
    ];

    public function mount()
    {
    	$this->status = 'index';
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->permission_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->permission_id = $id;
    		$this->edit();
    	}
        if($value == 'destroy')
        {
            $this->permission_id = $id;
            $this->destroy();
        }
    }

    public function create()
    {
		$this->name = '';
		$this->guard_name = '';
		$this->description = '';
    }

    public function edit()
    {
    	$permission = Permission::find($this->permission_id);
		$this->name = $permission->name;
		$this->guard_name = $permission->guard_name;
		$this->description = $permission->description;
    }
    
    public function destroy()
    {
     	$permission = Permission::find($this->permission_id);
		$this->name = $permission->name;
		$this->guard_name = $permission->guard_name;
		$this->description = $permission->description;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
            $aroles = [];
            foreach ($this->roles as $item) {
                $role = Role::findOrFail($item);
                $aroles[] = $role;
            }
	    	$permission = Permission::find($this->permission_id);
			$permission->name = $this->name ;
			$permission->guard_name = $this->guard_name ;
			$permission->description = $this->description ;
			$permission->save();
            $permission->syncRoles($aroles);
    	}elseif( $this->status == 'create'){
            $this->validate();
            $aroles = [];
            foreach ($this->roles as $item) {
                $role = Role::findOrFail($item);
                $aroles[] = $role;
            }
	    	$permission = Permission::create([
				'name' => $this->name ,
				'guard_name' => $this->guard_name ,
				'description' => $this->description ,
	    	])->syncRoles($aroles);
    	}elseif( $this->status == 'destroy'){
            $permission = Permission::find($this->permission_id);
            $permission->delete();
        }

    	$this->status = 'index';
        $this->render();

    }
}
