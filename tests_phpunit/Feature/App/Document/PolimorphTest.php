<?php

namespace Tests_phpunit\Feature\App\Document;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Document;
use App\Models\Employee;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\User;
use Tests_phpunit\TestCase;

class PolimorphTest extends TestCase
{
    use DatabaseTransactions;
    
    public function test_student_subject(): void
    {

        $document = Document::create([
            'date' => now(),
            'origin' => 'Entidad externa', 
            'office_id' => 1, 
            'filename' => 'documento.pdf', 
            'link' => 'as5f1s5d.pdf', 
            'display' => 'public', 
            'status' => 'pendiente'
        ]);

        $student = Student::find(1);

        $nn = Subject::create([
            'subjectable_type' => Student::class,
            'subjectable_id' => $student->id,
            'document_id' => $document->id
        ]);

        $this->assertTrue($student->subject->document_id == $document->id);

    }

    public function test_employee_subject(): void
    {

        $document = Document::create([
            'date' => now(),
            'origin' => 'Entidad externa', 
            'office_id' => 1, 
            'filename' => 'documento.pdf', 
            'link' => 'as5f1s5d.pdf', 
            'display' => 'public', 
            'status' => 'pendiente'
        ]);

        $employee = Employee::find(1);

        $nn = Subject::create([
            'subjectable_type' => Employee::class,
            'subjectable_id' => $employee->id,
            'document_id' => $document->id
        ]);

        $this->assertTrue($employee->subject->document_id == $document->id);

    }

}