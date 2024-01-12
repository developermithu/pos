<?php

namespace App\Livewire\Expenses;

use App\Livewire\Forms\ExpenseForm;
use App\Models\Account;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
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
        try {
            DB::beginTransaction();

            $this->form->store();
            $this->form->reset();

            DB::commit();
            $this->success(__('Record has been created successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating expense: ' . $e->getMessage());

            $this->error(__('Something went wrong!'));
        }

        return back();
    }

    public function render()
    {
        $accounts = Account::active()->pluck('name', 'id');

        return view('livewire.expenses.create-expense', compact('accounts'))
            ->title(__('add expense'));
    }
}
