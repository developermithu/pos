<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use Livewire\Component;

class CreateExpense extends Component
{
    public ExpenseForm $form;

    public function save()
    {
        $this->form->store();

        $this->form->reset();

        session()->flash('status', 'Record created successfully.');
        return back();
    }

    public function render()
    {
        return view('livewire.expenses.create-expense')->title(__('add expense'));
    }
}
