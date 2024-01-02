<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Cash',
            'initial_balance' => 0,
            'total_balance' => 0,
            'is_default' => false,
            'is_active' => true,
            'details' => 'Cashbook account'
        ]);

        Account::create([
            'account_no' => rand(10000, 50000),
            'name' => 'Sonali bank',
            'initial_balance' => 100000,
            'total_balance' => 500000,
            'is_default' => true,
            'is_active' => true,
            'details' => 'Sonali bank account'
        ]);

        Account::create([
            'account_no' => rand(10000, 50000),
            'name' => 'Bkash',
            'initial_balance' => 100,
            'total_balance' => 5000,
            'is_default' => false,
            'is_active' => true,
            'details' => 'Bkash account'
        ]);

        Account::create([
            'account_no' => rand(10000, 50000),
            'name' => 'Dutch Bangla Bank',
            'initial_balance' => 3000,
            'total_balance' => 20000,
            'is_default' => false,
            'is_active' => false,
            'details' => 'Dutch Bangla Bank Account'
        ]);
    }
}
