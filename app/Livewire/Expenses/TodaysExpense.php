<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class TodaysExpense extends Component
{
    public function render()
    {
        $todaysExpenses = Expense::where('date', date('Y-m-d'))->get();
        $todaysTotalExpense = Expense::where('date', date('Y-m-d'))->sum('amount') / 100;

        return view('livewire.expenses.todays-expense', compact('todaysExpenses', 'todaysTotalExpense'));
    }
}
