<?php

namespace Tests_phpunit\Feature\App\Document;

// use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->markTestSkipped('must be revisited.');

        $document = Document::create([
            'date' => now(),
            'origin' => 'Entidad externa', 
            'office_id' => 1, 
            'abstract' => 'Nuevo Resumen del documento.',
            'state' => 'pendiente'
        ]);
        
        $nn = Attach::create([
            'attachtable_type' => Document::class,
            'attachtable_id' => $document->id,
            'filename' => 'documento.pdf', 
            'link' => 'as5f1s5d.pdf', 
            'display' => 'public', 
        ]);

        $this->assertTrue($document->attach->filename == $nn->filename);

    }

    public function test_target_attach(): void
    {

        $this->markTestSkipped('must be revisited.');

        $target = Target::create([
            'date' => now(),
            'origin' => 'Entidad externa', 
            'office_id' => 1, 
            'abstract' => 'Nuevo Resumen del documento.',
            'state' => 'pendiente'
        ]);
        
        $nn = Attach::create([
            'attachtable_type' => Target::class,
            'attachtable_id' => $target->id,
            'filename' => 'documento.pdf', 
            'link' => 'as5f1s5d.pdf', 
            'display' => 'public', 
        ]);

        $this->assertTrue($target->attach->link == $nn->link);

    }

}