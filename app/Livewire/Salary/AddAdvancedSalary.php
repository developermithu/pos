<?php

namespace App\Livewire\Salary;

use App\Livewire\Forms\AdvancedSalaryForm;
use App\Models\Employee;
use Livewire\Component;

class AddAdvancedSalary extends Component
{
    public AdvancedSalaryForm $form;

    public function save()
    {
        $this->form->store();
    }

    public function render()
    {
        $employees = Employee::pluck('name', 'id');
        return view('livewire.salary.add-advanced-salary', compact('employees'));
    }
}
