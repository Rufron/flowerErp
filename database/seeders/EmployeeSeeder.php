<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
       Employee::updateOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password123'),
            ]
        );

        Employee::updateOrCreate(
            ['email' => 'jane@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => bcrypt('password123'),
            ]
        );
    }
}
