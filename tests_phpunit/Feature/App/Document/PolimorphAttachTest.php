<?php

namespace Tests_phpunit\Feature\App\Document;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Attach;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Target;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use Tests_phpunit\TestCase;

class PolimorphAttachTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_document_attach(): void
    {

        $document = Document::create([
            'date' => now(),
            'origin' => 'Entidad externa', 
            'office_id' => 1, 
            'abstract' => 'Nuevo Resumen del documento.',
            'state' => 'pendiente'
        ]);
        
        $nn = Attach::create([
            'attachable_type' => Document::class,
            'attachable_id' => $document->id,
            'filename' => 'documento.pdf', 
            'link' => 'as5f1s5d.pdf', 
            'display' => 'public', 
        ]);

        $this->assertTrue($document->attach[0]->filename == $nn->filename);

    }

    public function test_target_attach(): void
    {

        // $this->markTestSkipped('must be revisited.');

        $data_target = [
            'office_id' => 1, 
            'state' => 'pendiente',
            'document_id' => 1, 
            'user_id' => 1, 
            'task_id' => 1, 
            'expiry' => now(),
        ];

        $target = Target::create($data_target);

        $this->assertDatabaseHas('targets', $data_target);
        
        $data_attach = [
            'attachable_type' => Target::class,
            'attachable_id' => $target->id,
            'filename' => 'documento.pdf', 
            'link' => 'as5f1s5d.pdf', 
            'display' => 'public', 
        ];

        $attach = Attach::create($data_attach);

        $this->assertDatabaseHas('attaches', $data_attach);
        
        $this->assertTrue($target->attach[0]->link == $attach->link);

    }

}