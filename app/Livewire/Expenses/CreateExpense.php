<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Expense;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateExpense extends Component
{
    use Toast;
    
    public ExpenseForm $form;

    public function mount()
    {
        $this->authorize('create', Expense::class);
    }

    public function save()
    {
        $this->form->store();

        $this->form->reset();

        $this->success(__('Record has been created successfully'));
        return back();
    }

    public function render()
    {
        return view('livewire.expenses.create-expense')->title(__('add expense'));
    }
}
