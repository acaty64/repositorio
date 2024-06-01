<?php

namespace App\Livewire;

use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\Route; 
use Illuminate\Validation\Validator;
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
    public $rutas;

    public function render()
    {
        return view('livewire.permission-index', [
            'permissions' => Permission::paginate(5)
        ]);
    }

    protected function rules()
    {
        return [
            'name' => 'required|max:250',
            'description' => 'required|max:250',
        ];
    }
    
    public function mount()
    {
        $this->status = 'index';
        $this->check_roles = [1];
    }
    
    public function route_exists($name)
    {
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) {
            if ($value->getName() == $name) {
                return true;
            }
        }
        return false;
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
            $this->withValidator(function (Validator $validator) {
                $validator->after(function ($validator) {
                    if (!$this->route_exists($this->name)) {
                        $validator->errors()->add('name', 'La ruta no existe.');
                    }
                });
            })->validate();

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
            $this->withValidator(function (Validator $validator) {
                $validator->after(function ($validator) {
                    if (!$this->route_exists($this->name)) {
                        $validator->errors()->add('name', 'La ruta no existe.');
                    }
                });
            })->validate();

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
