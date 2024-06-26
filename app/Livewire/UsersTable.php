<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

class UsersTable extends DataTableComponent
{

    protected $model = User::class;
 
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }
 
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),
            Column::make('Nombre', 'name')
                ->sortable(),
            Column::make('Email', 'email')
                ->sortable(),
            DateColumn::make('F.Creación', 'updated_at')
                ->sortable()
                ->outputFormat('d-m-Y'),
        ];
    }

}
