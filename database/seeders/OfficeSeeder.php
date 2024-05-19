<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::create([
            'name' => 'Gran Cancillería',
            'abbrev' => 'GC',
            'level' => 1
        ]);

        Office::create([
            'name' => 'Asamblea General',
            'abbrev' => 'AG',
            'level' => 2
        ]);

        Office::create([
            'name' => 'Consejo Universitario',
            'abbrev' => 'CU',
            'level' => 3
        ]);

        Office::create([
            'name' => 'Rectorado',
            'abbrev' => 'R',
            'level' => 4
        ]);

        Office::create([
            'name' => 'Vicerectorado Académico',
            'abbrev' => 'VAcad',
            'level' => 5
        ]);

        Office::create([
            'name' => 'Vicerectorado Administrativo',
            'abbrev' => 'VAdm',
            'level' => 5
        ]);    
        
        Office::create([
            'name' => 'Facultad de Ciencias Agrarias y Ambientales',
            'abbrev' => 'FCAA',
            'level' => 6
        ]);

        Office::create([
            'name' => 'Facultad de Ciencias Económicas y Comerciales',
            'abbrev' => 'FCEC',
            'level' => 6
        ]);    

        Office::create([
            'name' => 'Facultad de Ciencias de la Educación y Humanidades',
            'abbrev' => 'FCEH',
            'level' => 6
        ]);    

        Office::create([
            'name' => 'Facultad de Ciencias de la Salud',
            'abbrev' => 'FCS',
            'level' => 6
        ]);    

        Office::create([
            'name' => 'Facultad de Derecho y Ciencias Políticas',
            'abbrev' => 'FDCP',
            'level' => 6
        ]);    

        Office::create([
            'name' => 'Facultad de Ingeniería',
            'abbrev' => 'FI',
            'level' => 6
        ]);    


        
    }
}
