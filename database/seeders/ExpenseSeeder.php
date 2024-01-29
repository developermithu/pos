<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expense_category1 = ExpenseCategory::create([
            'name' => 'কর্মচারীদের বেতন',
            'description' => 'কর্মচারীদের খরচের বিবরণ',
        ]);

        $expense_category2 = ExpenseCategory::create([
            'name' => 'কারেন্ট বিল',
            'description' => 'কারেন্ট বিলের বিবরণ',
        ]);

        $expense_category3 = ExpenseCategory::create([
            'name' => 'জলখাবার',
            'description' => 'জলখাবারের বিবরণ',
        ]);

        Expense::create([
            'expense_category_id' => $expense_category1->id,
            'details' => 'কর্মচারীদের বেতন প্রদান',
            'amount' => '10000',
            'date' => now()->addMonths(-1),
        ]);

        Expense::create([
            'expense_category_id' => $expense_category3->id,
            'details' => 'জলখাবার',
            'amount' => '500',
            'date' => now()->addWeek(-1),
        ]);

        Expense::create([
            'expense_category_id' => $expense_category2->id,
            'details' => 'কারেন্ট বিল',
            'amount' => '2500',
            'date' => today(),
        ]);
    }
}
