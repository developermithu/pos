<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class YearlyExpenses extends Component
{
    public function render()
    {
        $this->authorize('viewAny', Expense::class);

        $yearlyExpenses = Expense::whereYear('date', now()->year)->paginate(20);
        $yearlyTotalExpense = Expense::whereYear('date', now()->year)->sum('amount') / 100;

        return view('livewire.expenses.yearly-expenses', compact('yearlyExpenses', 'yearlyTotalExpense'))
            ->title(__('yearly expenses'));
    }
}
