<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Account;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
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
        try {
            DB::beginTransaction();

            $this->form->update();

            DB::commit();

            $this->success(__('Record has been updated successfully'));
            return $this->redirect(ListExpense::class, navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating expense: ' . $e->getMessage());

            $this->error(__('Something went wrong!'));
        }

        return back();
    }

    public function render()
    {
        $accounts = Account::active()->pluck('name', 'id');
        
        return view('livewire.expenses.edit-expense', compact('accounts'))
            ->title(__('edit expense'));
    }
}
