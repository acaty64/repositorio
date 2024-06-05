<?php

namespace tests_phpunit\Feature\Task;

use App\Livewire\TaskIndex;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests_phpunit\TestCase;

class LivewireTaskTest extends TestCase
{
    use DatabaseTransactions;
    public function test_task_index_page_contains_livewire_component()
    {
        $master = User::find(1);
        $this->actingAs($master);
        Livewire::test(TaskIndex::class)
        ->assertSeeHtml('Tarea')
        ->assertSeeHtml('Tipo')
        ->assertSeeHtml('Color')
        ->assertSeeHtml('Orden')
        ->assertSeeHtml('Usuario')
        ;
        
    }
    
    public function test_master_can_add_task_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);
        
        Livewire::test(TaskIndex::class)
        ->set('status', 'create')
        ->assertSeeHtml('Nueva Tarea');
        
        // 'name', 'type', 'color','order', 'user_id'
        $data = [
            'name' => 'Nueva Tarea',
            'type' => 'private',
            'color' => 'red',
            'order' => 1,
            'user_id' => 3
        ];
        
        $this->actingAs($master);
        Livewire::test(TaskIndex::class)
            ->call('setStatus', 'create')
            ->set('name', $data['name'])
            ->set('type', $data['type'])
            ->set('color', $data['color'])
            ->set('order', $data['order'])
            ->set('user_id', $data['user_id'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('tasks', $data);

    }

    public function test_master_can_update_task_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        $data = [
            'name' => 'Nueva Tarea',
            'type' => 'private',
            'color' => 'red',
            'order' => 1,
            'user_id' => 3
        ];
        
        $task = Task::create($data);
        $this->assertDatabaseHas('tasks', $data);
        
        $newData = [
            'name' => 'Otra Nueva Tarea',
            'type' => 'public',
            'color' => 'blue',
            'order' => 3,
            'user_id' => 4
        ];

        Livewire::actingAs($master)
            ->test(TaskIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Tarea');

        Livewire::actingAs($master)
            ->test(TaskIndex::class)
            ->call('setStatus', 'edit', $task->id)
            ->assertSet('name', $data['name'])
            ->set('name', $newData['name'])
            ->set('type', $newData['type'])
            ->set('color', $newData['color'])
            ->set('order', $newData['order'])
            ->set('user_id', $newData['user_id'])
            ->call('save');

        $this->assertDatabaseHas('tasks', $newData);
        $this->assertDatabaseMissing('tasks', $data);

    }

    public function test_master_can_destroy_a_task_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);
        $task = Task::create([
            'name' => 'Nueva Tarea',
            'type' => 'private',
            'color' => 'red',
            'order' => 1,
            'user_id' => 3
        ]);
        
        Livewire::test(TaskIndex::class)
            ->call('setStatus', 'destroy', $task->id)
            ->assertSet('task_id', $task->id)
            ->assertSeeHtml('Tarea a Eliminar')
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseMissing('tasks', $task->toArray());

    }

}