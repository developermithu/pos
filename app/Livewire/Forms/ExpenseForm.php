<?php

namespace App\Livewire\Forms;

use App\Enums\PaymentType;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Payment;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ExpenseForm extends Form
{
    public ?Expense $expense;

    public int|string $expense_category_id = '';
    public int|string $account_id = '';
    public ?int $amount;
    public ?string $details = null;

    public function setExpense(Expense $expense)
    {
        $this->expense = $expense;

        $this->details = $expense->details;
        $this->amount = $expense->amount;
        $this->expense_category_id = $expense->expense_category_id;
        $this->account_id = $expense->payment->account_id;
    }

    public function store()
    {
        $this->validate();

        $expense = Expense::create([
            'expense_category_id' => $this->expense_category_id,
            'details' => $this->details,
            'amount' => $this->amount,
            'date' => date('Y-m-d'),
        ]);

        // Creating Payment
        Payment::create([
            'account_id' => $this->account_id,
            'amount' => $this->amount,
            'reference' => 'Expense-'.date('Ymd').'-'.rand(00000, 99999),
            'type' => PaymentType::DEBIT->value,
            'paymentable_id' => $expense->id,
            'paymentable_type' => Expense::class,
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->expense->update([
            'expense_category_id' => $this->expense_category_id,
            'details' => $this->details,
            'amount' => $this->amount,
        ]);

        // Update Payment
        $this->expense->payment->update([
            'account_id' => $this->account_id,
            'amount' => $this->amount,
        ]);
    }

    protected function rules(): array
    {
        return [
            'expense_category_id' => ['required', Rule::exists(ExpenseCategory::class, 'id')],
            'account_id' => ['required', Rule::exists(Account::class, 'id')],
            'amount' => ['required', 'integer'],
            'details' => ['nullable', 'max:255'],
        ];
    }
}
