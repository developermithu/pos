<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Expense;
use Livewire\Component;

class CreateExpense extends Component
{
    public ExpenseForm $form;

    public function mount()
    {
        $this->authorize('create', Expense::class);
    }

    public function save()
    {
        $this->form->store();

        $this->form->reset();

        session()->flash('status', __('Record has been created successfully'));
        return back();
    }

    public function render()
    {
        return view('livewire.expenses.create-expense')->title(__('add expense'));
    }
}
