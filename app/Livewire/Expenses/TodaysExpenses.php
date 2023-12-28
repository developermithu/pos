<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class TodaysExpenses extends Component
{
    public function render()
    {
        $this->authorize('viewAny', Expense::class);

        $todaysExpenses = Expense::whereDay('date', now()->today())->get();
        $todaysTotalExpense = Expense::whereDay('date', now()->today())->sum('amount') / 100;

        return view('livewire.expenses.todays-expenses', compact('todaysExpenses', 'todaysTotalExpense'))->title(__('todays expenses'));
    }
}
