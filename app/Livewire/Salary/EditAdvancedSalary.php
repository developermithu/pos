<?php

namespace App\Livewire\Salary;

use App\Livewire\Forms\AdvancedSalaryForm;
use App\Models\AdvancedSalary;
use App\Models\Employee;
use Livewire\Component;
use Mary\Traits\Toast;

class EditAdvancedSalary extends Component
{
    use Toast;

    public AdvancedSalaryForm $form;

    public function mount(AdvancedSalary $advanced_salary)
    {
        $this->authorize('update', $advanced_salary);
        $this->form->setAdvancedSalary($advanced_salary);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));
        return $this->redirect(ListAdvancedSalary::class, navigate: true);
    }

    public function render()
    {
        $employees = Employee::pluck('name', 'id');
        return view('livewire.salary.edit-advanced-salary', compact('employees'))
            ->title(__('update advanced salary'));
    }
}
