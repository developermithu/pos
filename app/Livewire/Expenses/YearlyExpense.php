<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class YearlyExpense extends Component
{
    public function render()
    {
        $year = date('Y');

        $yearlyExpenses = Expense::where('year', $year)->paginate(20);
        $yearlyTotalExpense = Expense::where('year', $year)->sum('amount') / 100;

        return view('livewire.expenses.yearly-expense', compact('yearlyExpenses', 'yearlyTotalExpense'));
    }
}
