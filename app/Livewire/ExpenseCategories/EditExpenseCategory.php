<?php

namespace App\Livewire\ExpenseCategories;

use App\Livewire\Forms\ExpenseCategoryForm;
use App\Models\ExpenseCategory;
use Livewire\Component;
use Mary\Traits\Toast;

class EditExpenseCategory extends Component
{
    use Toast;

    public ExpenseCategoryForm $form;

    public function mount(ExpenseCategory $expenseCategory)
    {
        $this->authorize('update', $expenseCategory);
        $this->form->setExpenseCategory($expenseCategory);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));

        return $this->redirect(ListExpenseCategory::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.expense-categories.edit-expense-category')
            ->title(__('update expense category'));
    }
}
