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
        $this->authorize('update', $expense);
        $this->form->setExpense($expense);
    }

    public function save()
    {
        $this->form->update();

        session()->flash('status', __('Record has been updated successfully'));
        return $this->redirect(TodaysExpenses::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.expenses.edit-expense')->title(__('edit expense'));
    }
}
