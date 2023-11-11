<?php

namespace App\Livewire\Salary;

use App\Models\Employee;
use Livewire\Component;

class ListPaySalary extends Component
{
    public function render()
    {
        $employees = Employee::with(['advanceSalary', 'paySalary'])->oldest()->get();

        return view('livewire.salary.list-pay-salary', compact('employees'))
            ->title(__('pay salary list'));
    }
}
