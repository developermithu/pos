<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account::create([
            'account_no' => 12345,
            'name' => 'Cashbook',
            'initial_balance' => 50000,
            'is_active' => true,
            'details' => 'Cashbook account',
        ]);

        Account::create([
            'account_no' => rand(10000, 50000),
            'name' => 'Sonali bank',
            'initial_balance' => 100000,
            'is_active' => true,
            'details' => 'Sonali bank account',
        ]);

        Account::create([
            'account_no' => rand(10000, 50000),
            'name' => 'Bkash',
            'initial_balance' => 100,
            'is_active' => true,
            'details' => 'Bkash account',
        ]);

        Account::create([
            'account_no' => rand(10000, 50000),
            'name' => 'Dutch Bangla Bank',
            'initial_balance' => 3000,
            'is_active' => false,
            'details' => 'Dutch Bangla Bank Account',
        ]);
    }
}
