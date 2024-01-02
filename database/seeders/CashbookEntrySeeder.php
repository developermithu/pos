<?php

namespace Database\Seeders;

use App\Enums\CashbookEntryType;
use App\Models\CashbookEntry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CashbookEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cashbookEntries = [
            // Store 1 deposit and expense entries
            [
                'store_id' => 1,
                'account_id' => 1,
                'amount' => 11000,
                'type' => CashbookEntryType::DEPOSIT->value,
                'note' => 'Deposit Entry 2',
                'date' => now()->today(),
            ],
            [
                'store_id' => 1,
                'account_id' => 1,
                'amount' => 1000,
                'type' => CashbookEntryType::EXPENSE->value,
                'note' => 'Expense Entry 2',
                'date' => now()->yesterday(),
            ],
            [
                'store_id' => 1,
                'account_id' => 1,
                'amount' => 10000,
                'type' => CashbookEntryType::EXPENSE->value,
                'note' => 'Expense Entry 1',
                'date' => now()->addMonth(-1),
            ],
            [
                'store_id' => 1,
                'account_id' => 1,
                'amount' => 500000,
                'type' => CashbookEntryType::DEPOSIT->value,
                'note' => 'Deposit Entry 1',
                'date' => now()->addYear(),
            ],

            // total expense = 11,000
            // total deposit = 5,11000
            // balance = 5,00000

            // Store 2 deposit and expense entries
            [
                'store_id' => 2,
                'account_id' => 1,
                'amount' => 50000,
                'type' => CashbookEntryType::DEPOSIT->value,
                'note' => 'Deposit Entry 2',
                'date' => now()->today(),
            ],
            [
                'store_id' => 2,
                'account_id' => 1,
                'amount' => 250000,
                'type' => CashbookEntryType::EXPENSE->value,
                'note' => 'Expense Entry 2',
                'date' => now()->yesterday(),
            ],
            [
                'store_id' => 2,
                'account_id' => 1,
                'amount' => 50000,
                'type' => CashbookEntryType::EXPENSE->value,
                'note' => 'Expense Entry 1',
                'date' => now()->addMonth(-1),
            ],
            [
                'store_id' => 2,
                'account_id' => 1,
                'amount' => 200000,
                'type' => CashbookEntryType::DEPOSIT->value,
                'note' => 'Deposit Entry 1',
                'date' => now()->addYear(),
            ],

            // total expense = 3,00000
            // total deposit = 2,50,000
            // balance = 50,000

            // Store 3 deposit and expense entries
            [
                'store_id' => 3,
                'account_id' => 1,
                'amount' => 5000,
                'type' => CashbookEntryType::DEPOSIT->value,
                'note' => 'Deposit Entry 3',
                'date' => now()->today(),
            ],
            [
                'store_id' => 3,
                'account_id' => 1,
                'amount' => 3000,
                'type' => CashbookEntryType::DEPOSIT->value,
                'note' => 'Deposit Entry 2',
                'date' => now()->yesterday(),
            ],
            [
                'store_id' => 3,
                'account_id' => 1,
                'amount' => 5000,
                'type' => CashbookEntryType::EXPENSE->value,
                'note' => 'Expense Entry 2',
                'date' => now()->addDays(-20),
            ],
            [
                'store_id' => 3,
                'account_id' => 1,
                'amount' => 5000,
                'type' => CashbookEntryType::EXPENSE->value,
                'note' => 'Expense Entry 1',
                'date' => now()->addDays(-20),
            ],
            [
                'store_id' => 3,
                'account_id' => 1,
                'amount' => 2000,
                'type' => CashbookEntryType::DEPOSIT->value,
                'note' => 'Deposit Entry 1',
                'date' => now()->addDays(-25),
            ],

            // total expense = 10,000
            // total deposit = 10,000
            // balance = 0

        ];

        foreach ($cashbookEntries as $entry) {
            CashbookEntry::updateOrCreate($entry);
        }
    }
}
