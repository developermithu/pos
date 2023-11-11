<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Expense;
use Livewire\Component;

class EditExpense extends Component
{
    public ExpenseForm $form;

    public function mount(Expense $expense)
    {
        $this->form->setExpense($expense);
    }

    public function save()
    {
        $this->form->update();

        session()->flash('status', 'Record updated successfully.');
        return $this->redirect(TodaysExpense::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.expenses.edit-expense')->title(__('edit expense'));
    }
}
