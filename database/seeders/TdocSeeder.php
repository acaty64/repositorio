<?php

namespace Database\Seeders;

use App\Models\Tdoc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TdocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tdoc::create([
            'name' => 'Resolución'
        ]);

        Tdoc::create([
            'name' => 'Oficio'
        ]);

        Tdoc::create([
            'name' => 'Memorandum'
        ]);

        Tdoc::create([
            'name' => 'Comunicado'
        ]);

        Tdoc::create([
            'name' => 'Carta'
        ]);

        Tdoc::create([
            'name' => 'Convenio'
        ]);

        Tdoc::create([
            'name' => 'Informe'
        ]);

    }
}
