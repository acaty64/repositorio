<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'name' => 'Responder directamente al origen.',
            'type' => 'public',
            'color' => 'red',
            'order' => 1
        ]);

        Task::create([
            'name' => 'Responder al remitente.',
            'type' => 'public',
            'color' => 'red',
            'order' => 2
        ]);

        Task::create([
            'name' => 'Ejecutar.',
            'type' => 'public',
            'color' => 'red',
            'order' => 3
        ]);

        Task::create([
            'name' => 'Sólo informativo.',
            'type' => 'public',
            'color' => 'blue',
            'order' => 4
        ]);

        Task::create([
            'name' => 'Pendiente.',
            'type' => 'private',
            'color' => 'rojo',
            'order' => 5,
            'user_id' => 1
        ]);

    }
}
