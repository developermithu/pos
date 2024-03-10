<?php

namespace Database\Seeders;

use App\Enums\PaymentPaidBy;
use App\Enums\PaymentType;
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
        // Creating expense category
        $expense_category1 = ExpenseCategory::create([
            'name' => 'কর্মচারীদের বেতন',
            'details' => 'কর্মচারীদের খরচের বিবরণ',
        ]);

        $expense_category2 = ExpenseCategory::create([
            'name' => 'কারেন্ট বিল',
            'details' => 'কারেন্ট বিলের বিবরণ',
        ]);

        $expense_category3 = ExpenseCategory::create([
            'name' => 'জলখাবার',
            'details' => 'জলখাবারের বিবরণ',
        ]);

        $expense_category4 = ExpenseCategory::create([
            'name' => 'Others',
            'details' => 'অন্যান্য খরচ',
        ]);

        // Creating expenses
        
        // $expense1 = Expense::create([
        //     'expense_category_id' => $expense_category1->id,
        //     'details' => 'কর্মচারীদের বেতন প্রদান',
        //     'amount' => '10000',
        //     'date' => now()->addMonths(-1),
        // ]);

        // $expense2 = Expense::create([
        //     'expense_category_id' => $expense_category3->id,
        //     'details' => 'জলখাবার',
        //     'amount' => '500',
        //     'date' => now()->addWeek(-1),
        // ]);

        // $expense3 = Expense::create([
        //     'expense_category_id' => $expense_category2->id,
        //     'details' => 'কারেন্ট বিল',
        //     'amount' => '2500',
        //     'date' => today(),
        // ]);

        // // Attaching payments
        // $expense1->payment()->create([
        //     'account_id' => 1,
        //     'amount' => $expense1->amount,
        //     'reference' => 'Expense',
        //     'details' => $expense1->details,
        //     'type' => PaymentType::DEBIT->value,
        //     'paid_by' => PaymentPaidBy::CASH->value,
        // ]);

        // $expense2->payment()->create([
        //     'account_id' => 1,
        //     'amount' => $expense2->amount,
        //     'reference' => 'Expense',
        //     'details' => $expense2->details,
        //     'type' => PaymentType::DEBIT->value,
        //     'paid_by' => PaymentPaidBy::CASH->value,
        // ]);

        // $expense3->payment()->create([
        //     'account_id' => 1,
        //     'amount' => $expense3->amount,
        //     'reference' => 'Expense',
        //     'details' => $expense3->details,
        //     'type' => PaymentType::DEBIT->value,
        //     'paid_by' => PaymentPaidBy::CASH->value,
        // ]);
    }
}
