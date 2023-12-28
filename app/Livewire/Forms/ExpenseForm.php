<?php

namespace App\Livewire\Forms;

use App\Models\Expense;
use Livewire\Attributes\Rule;
use Livewire\Form;

class ExpenseForm extends Form
{
    public ?Expense $expense;

    #[Rule('required|string|max:500')]
    public $details;

    #[Rule('required|integer')]
    public $amount;

    #[Rule('required|exists:expense_categories,id', as: 'expense category')]
    public $expense_category_id;

    public function setExpense(Expense $expense)
    {
        $this->expense = $expense;

        $this->details = $expense->details;
        $this->amount = $expense->amount;
        $this->expense_category_id = $expense->expense_category_id;
    }

    public function store()
    {
        $this->validate();

        Expense::create([
            'expense_category_id' => $this->expense_category_id,
            'details' => $this->details,
            'amount' => $this->amount,
            'date' => date('Y-m-d'),
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->expense->update([
            'expense_category_id' => $this->expense_category_id,
            'details' => $this->details,
            'amount' => $this->amount,
            'date' => date('Y-m-d'),
        ]);
    }
}
