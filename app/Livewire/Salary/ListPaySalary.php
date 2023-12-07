<?php

namespace App\Livewire\Salary;

use App\Models\Employee;
use App\Models\PaySalary;
use Livewire\Component;

class ListPaySalary extends Component
{
    public function render()
    {
        $this->authorize('viewAny', PaySalary::class);

        $employees = Employee::with(['advanceSalary', 'paySalary'])->oldest()->get();

        return view('livewire.salary.list-pay-salary', compact('employees'))
            ->title(__('pay salary list'));
    }
}
