<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use Livewire\Component;

class MonthlyExpenses extends Component
{
    public function render()
    {
        $month = date('F');

        $monthlyExpenses = Expense::where('month', $month)->paginate(20);
        $monthlyTotalExpense = Expense::where('month', $month)->sum('amount') / 100;

        return view('livewire.expenses.monthly-expenses', compact('monthlyExpenses', 'monthlyTotalExpense'))->title(__('monthly expenses'));
    }
}
