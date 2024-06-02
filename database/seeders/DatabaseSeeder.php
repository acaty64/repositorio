<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TdocSeeder::class);
        $this->call(OfficeSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(EmployeeSeeder::class);

        // User::factory(10)->create();

    }
}
