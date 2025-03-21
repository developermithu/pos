<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\UserRole;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'name' => 'Developer Mithu',
            'email' => 'developermithu@gmail.com',
            'email_verified_at' => now(),
            'password' => 'developermithu',
            'remember_token' => Str::random(10),
            'role' => UserRole::IS_SUPERADMIN->value,
        ]);

        User::updateOrCreate([
            'name' => 'zihad khandokar',
            'email' => 'zihadkhandokar66@gmail.com',
            'email_verified_at' => now(),
            'password' => '#%&ZiHaD#%&',
            'remember_token' => Str::random(10),
            'role' => UserRole::IS_SUPERADMIN->value,
        ]);

        User::updateOrCreate([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'email_verified_at' => now(),
            'password' => 'manager',
            'remember_token' => Str::random(10),
            'role' => UserRole::IS_MANAGER->value,
        ]);

        User::updateOrCreate([
            'name' => 'Cashier',
            'email' => 'cashier@gmail.com',
            'email_verified_at' => now(),
            'password' => 'cashier',
            'remember_token' => Str::random(10),
            'role' => UserRole::IS_CASHIER->value,
        ]);

        // Seeders
        $this->call([
            // AccountSeeder::class,
            ExpenseSeeder::class,
            UnitSeeder::class,
            CategorySeeder::class,
        ]);

        // Supplier::factory(2)->create();
        // Customer::factory(2)->create();
        // Employee::factory(2)->create();
        // Product::factory(2)->create();
    }
}
