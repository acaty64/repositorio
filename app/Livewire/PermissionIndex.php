<?php

namespace App\Livewire;

use App\Models\RoleHasPermission;
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
    public $guard_name = 'web';
    public $description;
    public $roles = [];
    public $check_roles = [];

    public function render()
    {
        return view('livewire.permission-index', [
            'permissions' => Permission::paginate(5)
        ]);
    }

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
    ];

    public function mount()
    {
    	$this->status = 'index';
        $this->check_roles = [1];
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
		$this->name = "";
		$this->description = '';
        $data_roles = Role::all();
        $roles = [];
        foreach ($data_roles as $item) {
            $roles[] = ['id' =>$item->id, 'name' => $item->name]; 
        }
        $this->roles = $roles;
    }

    public function edit()
    {
    	$permission = Permission::find($this->permission_id);
		$this->name = $permission->name;
		$this->description = $permission->description;
        $this->roles = Role::all();
        $this->check_roles = RoleHasPermission::getRoles($this->permission_id);
    }
    
    public function destroy()
    {
     	$permission = Permission::find($this->permission_id);
		$this->name = $permission->name;
		$this->description = $permission->description;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
            $aroles = [];
            foreach ($this->check_roles as $item) {
                $role = Role::findOrFail($item);
                $aroles[] = $role;
            }
	    	$permission = Permission::find($this->permission_id);
			$permission->name = $this->name ;
			$permission->description = $this->description ;
			$permission->save();
            $permission->syncRoles($aroles);
    	}elseif( $this->status == 'create'){
            $this->validate();
            $aroles = [];
            foreach ($this->check_roles as $item) {
                $role = Role::findOrFail($item);
                $aroles[] = $role;
            }
	    	$permission = Permission::create([
				'name' => $this->name ,
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
