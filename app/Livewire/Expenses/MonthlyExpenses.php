<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class MonthlyExpenses extends Component
{
    public function render()
    {
        $this->authorize('viewAny', Expense::class);

        $monthlyExpenses = Expense::whereMonth('date', now()->month)->paginate(20);
        $monthlyTotalExpense = Expense::whereMonth('date', now()->month)->sum('amount') / 100;

        return view('livewire.expenses.monthly-expenses', compact('monthlyExpenses', 'monthlyTotalExpense'))
            ->title(__('monthly expenses'));
    }
}
