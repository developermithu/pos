<?php

namespace App\Livewire\Employees;

use App\Livewire\Forms\EmployeeForm;
use App\Models\Employee;
use Livewire\Component;

class EditEmployee extends Component
{
    public EmployeeForm $form;

    public function mount(Employee $employee)
    {
        $this->form->setEmployee($employee);
    }

    public function save()
    {
        $this->form->update();

        session()->flash('status', 'Record updated successfully.');
        return $this->redirect(ListEmployee::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.employees.edit-employee');
    }
}
