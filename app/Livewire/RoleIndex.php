<?php

namespace App\Livewire;

use App\Models\RoleHasPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;
use Livewire\WithPagination;

class RoleIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status;
    public $role_id;
    public $name;
    public $guard_name = 'web';
    public $description;
    public $permissions = [];
    public $check_permissions = [];
    public $checks = [];

    public function render()
    {
        return view('livewire.role-index', [
            'roles' => Role::paginate(5)
        ]);
    }
    
    protected $rules = [
        'name' => 'required',
    ];
    
    public function mount()
    {
        $this->status = 'index';
    }
    
    public function clickCheck()
    {
        $this->checks = Permission::select('id', 'description')
                        ->whereIn('id', $this->check_permissions)
                        ->orderBy('description', 'ASC')->get();
    }

    public function setStatus($value, $id = null)
    {
        $this->status = $value;
    	$this->role_id = $id;
    	if($value == 'create')
    	{
            $this->create();
    	}
    	if($value == 'edit')
    	{
            $this->role_id = $id;
    		$this->edit();
    	}
        if($value == 'destroy')
        {
            $this->role_id = $id;
            $this->destroy();
        }
    }

    public function create()
    {
        $this->name = "";
		$this->description = '';
        $data_permissions = Permission::orderBy('description', 'ASC')->get();
        $permissions = [];
        foreach ($data_permissions as $item) {
            $permissions[] = ['id' =>$item->id, 'description' => $item->description]; 
        }
        $this->permissions = $permissions;
        $this->check_permissions = [];
        $this->clickCheck();
    }
    
    public function edit()
    {
        $role = Role::find($this->role_id);
		$this->name = $role->name;
		$this->description = $role->description;
        $this->permissions = Permission::orderBy('description', 'ASC')->get();
        $this->check_permissions = RoleHasPermission::getPermissions($this->role_id);
        $this->clickCheck();
    }
    
    public function destroy()
    {
     	$role = Role::find($this->role_id);
		$this->name = $role->name;
		$this->description = $role->description;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
            $this->validate();
            $apermissions = [];
            foreach ($this->check_permissions as $item) {
                $permission = Permission::findOrFail($item);
                $apermissions[] = $permission;
            }
	    	$role = Role::find($this->role_id);
			$role->name = $this->name ;
			$role->save();
            $role->syncPermissions($apermissions);
    	}elseif( $this->status == 'create'){
            $this->validate();
            $apermissions = [];
            foreach ($this->check_permissions as $item) {
                $permission = Permission::findOrFail($item);
                $apermissions[] = $permission;
            }
	    	$role = Role::create([
				'name' => $this->name ,
	    	])->syncPermissions($apermissions);
    	}elseif( $this->status == 'destroy'){
            $role = Role::find($this->role_id);
            $role->delete();
        }

    	$this->status = 'index';
        $this->render();

    }
}
