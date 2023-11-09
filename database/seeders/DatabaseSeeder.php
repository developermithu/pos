<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => 'manager',
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin',
        ]);

        Supplier::factory(5000)->create();
        Customer::factory(5000)->create();
        Employee::factory(500)->create();
        Product::factory(500000)->create();
    }
}
