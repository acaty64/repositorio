<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Master',
            'email' => 'master@example.com',
        ])->assignRole('Master');

        $user = User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            ])->assignRole('Administrador');
            
        $user = User::factory()->create([
            'name' => 'Coordinador',
            'email' => 'coord@example.com',
        ])->assignRole('Coordinador');

        $user = User::factory()->create([
            'name' => 'Operador',
            'email' => 'operador@example.com',
        ])->assignRole('Operador');

    }
}
