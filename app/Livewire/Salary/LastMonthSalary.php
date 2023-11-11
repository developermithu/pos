<?php

namespace App\Livewire\Salary;

use App\Models\PaySalary;
use Carbon\Carbon;
use Livewire\Component;

class LastMonthSalary extends Component
{
    public function render()
    {
        $month = date('F', strtotime('-1 month'));
        $paidSalaries = PaySalary::with('employee')->where('month', $month)->get();

        return view('livewire.salary.last-month-salary', compact('paidSalaries'))
            ->title(__('last month salary'));
    }
}
