<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.user-index', [
            'users' => User::paginate(2)
        ]);
    }
}
