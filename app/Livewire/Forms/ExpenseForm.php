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

    public function setExpense(Expense $expense)
    {
        $this->expense = $expense;

        $this->details = $expense->details;
        $this->amount = $expense->amount;
    }

    public function store()
    {
        $this->validate();

        Expense::create([
            'details' => $this->details,
            'amount' => $this->amount,
            'month' => date('F'),
            'year' => date('Y'),
            'date' => date('Y-m-d'),
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->expense->update([
            'details' => $this->details,
            'amount' => $this->amount,
            'month' => date('F'),
            'year' => date('Y'),
            'date' => date('Y-m-d'),
        ]);
    }
}
