<?php

namespace tests_phpunit\Feature\Target;

use App\Livewire\TargetIndex;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests_phpunit\TestCase;

class LivewireTargetTest extends TestCase
{
    use DatabaseTransactions;

    public function test_target_index_page_contains_livewire_component()
    {
        $master = User::find(1);
        $this->actingAs($master);
        Livewire::test(TargetIndex::class)
            ->assertSeeHtml('Oficina')
            ->assertSeeHtml('Persona')
            ->assertSeeHtml('Tarea')
            ->assertSeeHtml('Estado')
            ->assertSeeHtml('Vencimiento')
            ;

    }

    public function test_master_can_add_target_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        Livewire::test(TargetIndex::class)
            ->set('status', 'create')
            ->assertSeeHtml('Nuevo Destino');

        $data = [
            'document_id' => 1,
            'office_id' => 1,
            'user_id' => 2,
            'task_id' => 1,
            'state' => 'private',
            'expiry' => Carbon::now(),
        ];

        $this->actingAs($master);
        Livewire::test(TargetIndex::class)
            ->call('setStatus', 'create')
            ->set('document_id', $data['document_id'])
            ->set('office_id', $data['office_id'])
            ->set('user_id', $data['user_id'])
            ->set('task_id', $data['task_id'])
            ->set('state', $data['state'])
            ->set('expiry', $data['expiry'])
            ->call('save');
            // ->assertSeeHtml('Registro grabado.');

        $this->assertDatabaseHas('targets', $data);

    }

    public function test_master_can_update_target_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);

        $data = [
            'document_id' => 1,
            'office_id' => 1,
            'user_id' => 2,
            'task_id' => 1,
            'state' => 'private',
            'expiry' => Carbon::now(),
        ];
        
        $target = Target::create($data);
        $this->assertDatabaseHas('targets', $data);
        
        $newData = [
            'document_id' => 1,
            'office_id' => 3,
            'user_id' => 4,
            'task_id' => 1,
            'state' => 'public',
            'expiry' => Carbon::now(),
        ];

        Livewire::actingAs($master)
            ->test(TargetIndex::class)
            ->set('status', 'edit')
            ->assertSeeHtml('Edición de Destino');

        Livewire::actingAs($master)
            ->test(TargetIndex::class)
            ->call('setStatus', 'edit', $target->id)
            ->assertSet('office_id', $data['office_id'])
            ->assertSet('user_id', $data['user_id'])
            ->assertSet('state', $data['state'])
            ->set('office_id', $newData['office_id'])
            ->set('user_id', $newData['user_id'])
            ->set('state', $newData['state'])
            ->set('expiry', $newData['expiry'])
            ->call('save');

        $this->assertDatabaseHas('targets', $newData);
        $this->assertDatabaseMissing('targets', $data);

    }

    public function test_master_can_destroy_a_target_registry()
    {
        $master = User::find(1);
        $this->actingAs($master);
        $data = [
            'document_id' => 1,
            'office_id' => 3,
            'user_id' => 4,
            'task_id' => 1,
            'state' => 'public',
            'expiry' => Carbon::now(),
        ];
        $target = Target::create($data);
        
        Livewire::test(TargetIndex::class)
            ->call('setStatus', 'destroy', $target->id)
            ->assertSet('target_id', $target->id)
            ->assertSeeHtml('Destino a Eliminar Id: ' . $target->id)
            ->call('save');
            // ->assertSeeHtml('Registro eliminado.');

        $this->assertDatabaseMissing('targets', $target->toArray());

    }

}