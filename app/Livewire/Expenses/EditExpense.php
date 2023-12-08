<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Expense;
use Livewire\Component;
use Mary\Traits\Toast;

class EditExpense extends Component
{
    use Toast;

    public ExpenseForm $form;

    public function mount(Expense $expense)
    {
        $this->authorize('update', $expense);
        $this->form->setExpense($expense);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));
        return $this->redirect(TodaysExpenses::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.expenses.edit-expense')->title(__('edit expense'));
    }
}
