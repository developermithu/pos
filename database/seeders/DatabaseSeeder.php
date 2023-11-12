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

        Supplier::factory(50)->create();
        Customer::factory(10)->create();
        Employee::factory(10)->create();
        Product::factory(20)->create();
    }
}
