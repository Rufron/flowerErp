<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Employee;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $employee = Employee::first(); // link products to first employee

        Product::create([
            'name' => 'Red Roses',
            'description' => 'A bouquet of fresh red roses',
            'stock' => 12,
            'image' => 'roses.jpg',
            'employee_id' => $employee->id,
        ]);

        Product::create([
            'name' => 'White Lilies',
            'description' => 'Elegant white lilies, perfect for events',
            'stock' => 8,
            'image' => 'lilies.jpg',
            'employee_id' => $employee->id,
        ]);
    }
}
